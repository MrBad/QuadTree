<?php

namespace MRB\QuadTree;

class AABB
{
    /**
     * @var float x1
     */
    private $minX;
    /**
     * @var float y1
     */
    private $minY;
    /**
     * @var float x2
     */
    private $maxX;
    /**
     * @var float y2
     */
    private $maxY;

    /**
     * Creates a new AABB
     * @param float $minX
     * @param float $minY
     * @param float $maxX
     * @param float $maxY
     */
    public function __construct(float $minX, float $minY, float $maxX, float $maxY)
    {
        if ($minX >= $maxX) {
            throw new \InvalidArgumentException("minX >= maxX");
        }
        
        if ($minY >= $maxY) {
            throw new \InvalidArgumentException("minY >= maxY");
        }
        
        $this->minX = $minX;
        $this->minY = $minY;
        $this->maxX = $maxX;
        $this->maxY = $maxY;
    }

    public function getMinX() : float
    {
        return $this->minX;
    }

    public function getMinY() : float
    {
        return $this->minY;
    }

    public function getMaxX() : float
    {
        return $this->maxX;
    }

    public function getMaxY() : float
    {
        return $this->maxY;
    }

    /**
     * Checks if this AABB fits into $aabb
     * @param AABB $aabb the container
     * @return bool
     */
    public function fitsIn(AABB $aabb) : bool
    {
        return
            $this->minX > $aabb->GetMinX() &&
            $this->minY > $aabb->GetMinY() &&
            $this->maxX < $aabb->GetMaxX() &&
            $this->maxY < $aabb->GetMaxY();
    }

    /**
     * Checks if this AABB intersects $aabb
     * @param AABB $aabb
     * @return bool
     */
    public function intersects(AABB $aabb) : bool
    {
        return $this->minX < $aabb->maxX &&
            $this->maxX > $aabb->minX &&
            $this->minY < $aabb->maxY &&
            $this->maxY > $aabb->minY;
    }

    public function __toString() : string
    {
        return $this->minX . ", " . $this->minY . ", " .
            $this->maxX . ", " . $this->maxY . "\n";
    }
}
