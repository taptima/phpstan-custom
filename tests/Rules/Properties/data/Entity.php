<?php

namespace Taptima\PHPStan\Rules\Properties;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Entity
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string")
     */
    private $surname;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Item", mappedBy="entity")
     */
    private $items;

    /**
     * Entity constructor.
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $surname
     *
     * @return Entity
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @param bool $enabled
     *
     * @return Entity
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param ArrayCollection $items
     *
     * @return Entity
     */
    public function setItems($items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getItems()
    {
        return $this->items;
    }
}
