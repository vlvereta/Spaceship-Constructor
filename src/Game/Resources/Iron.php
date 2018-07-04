<?php

namespace BinaryStudioAcademy\Game\Resources;

use BinaryStudioAcademy\Game\Contracts\ResourceInterface;

class Iron implements ResourceInterface
{
	public $need;
	private $amount;

	public function __construct() {
		$this->amount = 0;
		$this->need = array();
	}

	public function use() {
		$this->amount--;
	}

	public function produce() {
		$this->amount++;
	}

	public function getAmount() {
		return $this->amount;
	}
}
