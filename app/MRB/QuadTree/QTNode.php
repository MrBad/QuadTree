<?php

namespace MRB\QuadTree;

class QTNode
{
    /**
     * @var int max children a node has
     */
    const MAX_CHILDREN = 4;

    /**
     * @var int max number of QTObjects in a node
     */
    const MAX_OBJECTS = 2;

    /**
     * @var AABB
     */
    private $bounds;

    /**
     * @var QTNode[]
     */
    public $children;

    /**
     * @var QTObj[]
     */
    public $objects;

    /**
     * @param AABB $bounds
     */
    public function __construct(AABB $bounds)
    {
        $this->bounds = $bounds;
        $this->objects = [];
        $this->children = [];
    }

    /**
     * @return AABB this node bounds
     */
    public function getBounds() : AABB
    {
        return $this->bounds;
    }

    /**
     * @param AABB $aabb
     * @return int index of child that fits this aabb or -1 if does not fit
     * @throws \Exception
     */
    private function getIndexOfChildForAABB(AABB $aabb) : int
    {
        if (empty($this->children)) {
            throw new \Exception("Empty children\n");
        }
        for ($i = 0; $i < self::MAX_CHILDREN; $i++) {
            if ($aabb->fitsIn($this->children[$i]->GetBounds())) {
                return $i;
            }
        }
        return -1;
    }

    /**
     * Generates the children for this node
     */
    private function splitNode() : void
    {
        if (!empty($this->children)) {
            throw new \Exception("Children already split");
        }
        $bounds = [];
        $centerX = $this->bounds->GetMinX() + ($this->bounds->GetMaxX() - $this->bounds->GetMinX()) / 2;
        $centerY = $this->bounds->GetMinY() + ($this->bounds->GetMaxY() - $this->bounds->GetMinY()) / 2;
        $bounds[] = new AABB($centerX, $centerY, $this->bounds->GetMaxX(), $this->bounds->GetMaxY());
        $bounds[] = new AABB($this->bounds->GetMinX(), $centerY, $centerX, $this->bounds->GetMaxY());
        $bounds[] = new AABB($this->bounds->getMinX(), $this->bounds->GetMinY(), $centerX, $centerY);
        $bounds[] = new AABB($centerX, $this->bounds->GetMinY(), $this->bounds->GetMaxX(), $centerY);
        for ($i = 0; $i < self::MAX_CHILDREN; $i++) {
            $this->children[$i] = new QTNode($bounds[$i]);
        }
    }

    /**
     * @param QTObj $qtObj
     * @return bool
     * @throws \Exception
     */
    public function addObject(QTObj $qtObj) : bool
    {
        if (!($qtObj->GetBounds()->fitsIn($this->bounds))) {
            return false;
        }

        if (!empty($this->children)) {
            $idx = $this->getIndexOfChildForAABB($qtObj->GetBounds());
            if ($idx == -1) {
                $this->objects[] = $qtObj;
            } else {
                $this->children[$idx]->addObject($qtObj);
            }
        } else {
            if (count($this->objects) < self::MAX_OBJECTS) {
                $this->objects[] = $qtObj;
            } else {
                $this->splitNode();
                foreach ($this->objects as $key => $oldObject) {
                    if ($this->addObject($oldObject)) {
                        unset($this->objects[$key]);
                    }
                }
                return $this->addObject($qtObj);
            }
        }
        return true;
    }

    /**
     * @param AABB $box
     * @return QTObj[]
     */
    public function getIntersections(AABB $box) : array
    {
        $res = [];

        if (!$this->GetBounds()->intersects($box)) {
            return $res;
        }

        foreach ($this->objects as $qtObj) {
            if ($qtObj->GetBounds()->intersects($box)) {
                array_push($res, $qtObj);
            }
        }

        foreach ($this->children as $child) {
            if ($child->GetBounds()->intersects($box)) {
                $res = array_merge($res, $child->getIntersections($box));
            }
        }

        return $res;
    }
}
