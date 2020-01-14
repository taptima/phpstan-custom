<?php

namespace Taptima\PHPStan\Rules\Properties;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class EntityWithCollection
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Item", mappedBy="entityWithCollection")
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Item $item
     * @return EntityWithCollection
     */
    public function addItem(Item $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * @param Item $item
     * @return EntityWithCollection
     */
    public function removeItem(Item $item)
    {
        $this->items->removeElement($item);

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
