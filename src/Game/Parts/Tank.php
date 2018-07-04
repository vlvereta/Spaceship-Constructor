<?php

namespace BinaryStudioAcademy\Game\Parts;

use BinaryStudioAcademy\Game\Contracts\PartsInterface;

class Tank implements PartsInterface
{
	public $need;
	public $exist;

	public function __construct() {
		$exist = false;
		$this->need = array('metal', 'fuel');
	}

	public function produce($resources) {
		$this->use($resources);
		$this->exist = true;
	}

	private function use(Array $resources) {
		foreach ($this->need as $r) {
			if (array_key_exists($r, $resources)) {
				$resources[$r]->use();
			}
		}
	}
}
