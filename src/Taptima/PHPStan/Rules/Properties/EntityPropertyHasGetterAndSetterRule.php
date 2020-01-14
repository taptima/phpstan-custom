<?php

declare(strict_types=1);

namespace Taptima\PHPStan\Rules\Properties;

use Doctrine\Common\Inflector\Inflector;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MissingPropertyFromReflectionException;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\ShouldNotHappenException;
use PHPStan\Type\Doctrine\ObjectMetadataResolver;
use Throwable;

/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\PropertyProperty>
 */
final class EntityPropertyHasGetterAndSetterRule implements Rule
{
    /**
     * @var \PHPStan\Type\Doctrine\ObjectMetadataResolver
     */
    private $objectMetadataResolver;

    /**
     * EntityPropertyHasGetterAndSetterRule constructor.
     *
     * @param ObjectMetadataResolver $objectMetadataResolver
     */
    public function __construct(ObjectMetadataResolver $objectMetadataResolver)
    {
        $this->objectMetadataResolver = $objectMetadataResolver;
    }

    /**
     * {@inheritdoc}
     */
    public function getNodeType(): string
    {
        return \PhpParser\Node\Stmt\PropertyProperty::class;
    }

    /**
     * {@inheritdoc}
     *
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $class = $scope->getClassReflection();
        if ($class === null) {
            return [];
        }

        $objectManager = $this->objectMetadataResolver->getObjectManager();
        if ($objectManager === null) {
            return [];
        }

        $className = $class->getName();
        if ($objectManager->getMetadataFactory()->isTransient($className)) {
            return [];
        }

        try {
            $metadata = $objectManager->getClassMetadata($className);
        } catch (Throwable $e) {
            return [];
        }

        if (!$metadata instanceof ClassMetadataInfo) {
            return [];
        }

        $propertyName = (string) $node->name;
        try {
            $class->getNativeProperty($propertyName);
        } catch (MissingPropertyFromReflectionException $e) {
            return [];
        }

        if (!isset($metadata->fieldMappings[$propertyName]) && !isset($metadata->associationMappings[$propertyName])) {
            return [];
        }

        $messages = [];

        if (isset($metadata->fieldMappings[$propertyName])) {
            $messages = array_merge($messages, $this->checkCommonProperty($metadata, $class, $metadata->fieldMappings[$propertyName], $propertyName));
        }

        if (isset($metadata->associationMappings[$propertyName])) {
            $messages = array_merge($messages, $this->checkAssociationProperty($class, $metadata->associationMappings[$propertyName], $propertyName));
        }

        return $messages;
    }

    /**
     * @param ClassMetadataInfo $metadata
     * @param ClassReflection   $class
     * @param array             $fieldMapping
     * @param string            $propertyName
     *
     * @throws ShouldNotHappenException
     *
     * @return array
     */
    private function checkCommonProperty(ClassMetadataInfo $metadata, ClassReflection $class, array $fieldMapping, $propertyName)
    {
        $messages = [];

        $setter = sprintf('set%s', ucfirst($propertyName));
        $isser  = sprintf('is%s', ucfirst($propertyName));
        $hasser = sprintf('has%s', ucfirst($propertyName));
        $getter = sprintf('get%s', ucfirst($propertyName));

        if (!$class->hasMethod($setter) && !$metadata->isIdentifier($propertyName)) {
            $messages[] = $this->buildError($class, $propertyName, sprintf('must have a setter "%s"', $setter));
        }

        if ($fieldMapping['type'] !== Type::BOOLEAN) {
            if (!$class->hasMethod($getter)) {
                $messages[] = $this->buildError($class, $propertyName, sprintf('must have a getter "%s"', $getter));
            }

            return $messages;
        }

        $result  = false;
        $methods = [$isser, $hasser];
        foreach ($methods as $method) {
            $result = $result || $class->hasMethod($method);
        }

        $methodsStr = implode(', ', array_map(static function ($el): string {
            return sprintf('"%s"', $el);
        }, $methods));

        if (!$result) {
            $messages[] = $this->buildError($class, $propertyName, sprintf('must have one of the following methods %s', $methodsStr));
        }

        if ($class->hasMethod($getter)) {
            $messages[] = $this->buildError($class, $propertyName, sprintf('type of boolean must no have a getter "%s". Instead, it should have one of the following methods %s', $getter, $methodsStr));
        }

        return $messages;
    }

    /**
     * @param ClassReflection $class
     * @param array           $associationMapping
     * @param string          $propertyName
     *
     * @throws ShouldNotHappenException
     *
     * @return array
     */
    private function checkAssociationProperty(ClassReflection $class, array $associationMapping, $propertyName)
    {
        $messages = [];

        $getter = sprintf('get%s', ucfirst($propertyName));
        if (!$class->hasMethod($getter)) {
            $messages[] = $this->buildError($class, $propertyName, sprintf('must have a getter "%s"', $getter));
        }

        if ($associationMapping['type'] !== ClassMetadata::ONE_TO_MANY && $associationMapping['type'] !== ClassMetadata::MANY_TO_MANY) {
            $setter = sprintf('set%s', ucfirst($propertyName));
            if (!$class->hasMethod($getter)) {
                $messages[] = $this->buildError($class, $propertyName, sprintf('must have a setter "%s"', $setter));
            }

            return $messages;
        }

        $adders     = [];
        $removers   = [];
        $hasAdder   = false;
        $hasRemover = false;
        $singulars  = (array) Inflector::singularize($propertyName);
        foreach ($singulars as $singular) {
            $adder   = sprintf('add%s', ucfirst($singular));
            $remover = sprintf('remove%s', ucfirst($singular));

            $hasAdder   = $hasAdder || $class->hasMethod($adder);
            $hasRemover = $hasRemover || $class->hasMethod($remover);

            $adders[]   = $adder;
            $removers[] = $remover;
        }

        if (!$hasAdder) {
            $messages[] = $this->buildError($class, $propertyName, sprintf('must have an adder. E.g. %s', implode(', ', array_map(static function ($el): string {
                return sprintf('"%s"', $el);
            }, $adders))));
        }

        if (!$hasRemover) {
            $messages[] = $this->buildError($class, $propertyName, sprintf('must have an remover. E.g. %s', implode(', ', array_map(static function ($el): string {
                return sprintf('"%s"', $el);
            }, $removers))));
        }

        return $messages;
    }

    /**
     * @param ClassReflection $class
     * @param string          $propertyName
     * @param string          $message
     *
     * @throws ShouldNotHappenException
     *
     * @return \PHPStan\Rules\RuleError
     */
    private function buildError(ClassReflection $class, $propertyName, $message)
    {
        return RuleErrorBuilder::message(\sprintf('Property %s::$%s %s.', $class->getDisplayName(), $propertyName, $message))->build();
    }
}
