<?php
namespace MRB;

class QTObj
{
	/**
	 * @var AABB
	 */
	private $bounds;

	/**
	 * @param AABB $bounds
	 */
	public function __construct(AABB $bounds) {
		$this->bounds = $bounds;
	}

	/**
	 * Sets bounds
	 * @param AABB $bounds
	 */
	public function SetBounds(AABB $bounds) {
		$this->bounds = $bounds;
	}

	/**
	 * Gets bounds
	 * @return AABB
	 */
	public function GetBounds() {
		return $this->bounds;
	}
}
