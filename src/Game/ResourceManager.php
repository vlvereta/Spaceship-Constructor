<?php

namespace BinaryStudioAcademy\Game;

use BinaryStudioAcademy\Game\Contracts\Io\Writer;
use \BinaryStudioAcademy\Game\Resources\{Carbon, Copper, Fire, Fuel, Iron, Metal, Sand, Silicon, Water,};

class ResourceManager
{
	public $resources;

	public function __construct() {
		$this->resources = array(
			'carbon' => new Carbon(),
			'copper' => new Copper(),
			'fire' => new Fire(),
			'fuel' => new Fuel(),
			'iron' => new Iron(),
			'metal' => new Metal(),
			'sand' => new Sand(),
			'silicon' => new Silicon(),
			'water' => new Water(),
		);
	}

	public function status(Writer $w) {
		$w->writeINcolor("You have:\n", "\033[0;33;m");
		foreach ($this->resources as $key => $value) {
			$w->writeINcolor(" -> ", "\033[0;35;m");
			$color = ($value->getAmount() <= 0 ? "\033[0;31;m" : "\033[0;32;m");
			$w->writeINcolor("{$key} - " . $value->getAmount() . PHP_EOL, $color);
		}
	}

	public function mine(Writer $w, String $type) {
		if (array_key_exists($type, $this->resources)) {
			if ($type == 'metal') {
				$w->writeln(ucfirst($type) . ' resource may be produced!');
			} else {
				$this->resources[$type]->produce();
				$w->writeln(ucfirst($type) . ' added to inventory.');
			}
		} else {
			$w->writeln('No such resource.');
		}
	}

	public function produce(Writer $w, String $type) {
		if (array_key_exists($type, $this->resources)) {
			if ($type != 'metal') {
				$w->writeln(ucfirst($type) . ' resource may be mined!');
			} else if ($this->check($w, $this->resources[$type]->need)) {
				$this->resources[$type]->produce();
				$this->use($this->resources[$type]->need);
				$w->writeln(ucfirst($type) . ' added to inventory.');
			}
		} else {
			$w->writeln('No such resource.');
		}
	}

	private function check(Writer $w, Array $to_use) {
		$r = '';
		foreach ($to_use as $k) {
			if ($this->resources[$k]->getAmount() === 0) {
				if (!empty($r)) {
					$r .= ',';
				}
				$r .= $k;
			}
		}
		if (!empty($r)) {
			$w->writeln("You need to mine: {$r}.");
			return 0;
		}
		return 1;
	}

	public function use(Array $used) {
		foreach ($used as $r) {
			$this->resources[$r]->use();
		}
	}
}
