<?php

namespace Taptima\PHPStan\Rules\Properties;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class EntityWithBooleanFieldIsser
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param bool $enabled
     *
     * @return EntityWithBooleanFieldHasser
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }
}
