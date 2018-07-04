<?php

namespace BinaryStudioAcademy\Game\Resources;

use BinaryStudioAcademy\Game\Contracts\ResourceInterface;

class Metal implements ResourceInterface
{
	public	$need;
	private $amount;

	public function __construct() {
		$this->amount = 0;
		$this->need = array('iron', 'fire');
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
