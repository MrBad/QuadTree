<?php

namespace MRB\QuadTree;

class QTObj
{
    /**
     * @var AABB
     */
    private $bounds;

    /**
     * @param AABB $bounds
     */
    public function __construct(AABB $bounds)
    {
        $this->bounds = $bounds;
    }

    /**
     * Sets bounds
     * @param AABB $bounds
     */
    public function setBounds(AABB $bounds) : AABB
    {
        $this->bounds = $bounds;
        return $this;
    }

    /**
     * Gets bounds
     * @return AABB
     */
    public function getBounds() : AABB
    {
        return $this->bounds;
    }
}
