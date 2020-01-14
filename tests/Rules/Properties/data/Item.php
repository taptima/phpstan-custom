<?php

namespace Taptima\PHPStan\Rules\Properties;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Item
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Entity
     *
     * @ORM\ManyToOne(targetEntity="Entity", inversedBy="items")
     * @ORM\JoinColumn(name="entity_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $entity;

    /**
     * @var EntityWithCollection
     *
     * @ORM\ManyToOne(targetEntity="EntityWithCollection", inversedBy="items")
     * @ORM\JoinColumn(name="entity_with_collection_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $entityWithCollection;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Entity $entity
     *
     * @return Item
     */
    public function setEntity(Entity $entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * @return Entity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param EntityWithCollection $entityWithCollection
     *
     * @return Item
     */
    public function setEntityWithCollection(EntityWithCollection $entityWithCollection)
    {
        $this->entityWithCollection = $entityWithCollection;

        return $this;
    }

    /**
     * @return EntityWithCollection
     */
    public function getEntityWithCollection()
    {
        return $this->entityWithCollection;
    }
}
