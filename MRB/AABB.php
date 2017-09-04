<?php

namespace MRB;

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
	 * @param float $minX
	 * @param float $minY
	 * @param float $maxX
	 * @param float $maxY
	 */
	public function __construct($minX, $minY, $maxX, $maxY) {
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

	/**
	 * @return float minX
	 */
	public function GetMinX() {
		return $this->minX;
	}

	public function GetMinY() {
		return $this->minY;
	}

	public function GetMaxX() {
		return $this->maxX;
	}

	public function GetMaxY() {
		return $this->maxY;
	}

	/**
	 * Checks if this AABB fits into $aabb
	 * @param AABB $aabb the container
	 * @return bool
	 */
	public function fitsIn(AABB $aabb) {
		return $this->minX > $aabb->GetMinX() &&
		$this->minY > $aabb->GetMinY() &&
		$this->maxX < $aabb->GetMaxX() &&
		$this->maxY < $aabb->GetMaxY();
	}

	/**
	 * Checks if this AABB intersects $aabb
	 * @param AABB $aabb
	 * @return bool
	 */
	public function intersects(AABB $aabb) {
		return $this->minX < $aabb->maxX &&
		$this->maxX > $aabb->minX &&
		$this->minY < $aabb->maxY &&
		$this->maxY > $aabb->minY;
	}

	public function __toString() {
		return $this->minX . ", " . $this->minY . ", " .
		$this->maxX . ", " . $this->maxY . "\n";
	}
}
