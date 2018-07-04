<?php

namespace BinaryStudioAcademy\Game;

use BinaryStudioAcademy\Game\Contracts\Io\Writer;
use \BinaryStudioAcademy\Game\Parts\{ControlUnit, Engine, Ic, Launcher, Porthole, Shell, Tank, Wires};

class PartsManager
{
	public $parts;

	public function __construct() {
		$this->parts = array(
			'control_unit' => new ControlUnit(),
			'engine' => new Engine(),
			'ic' => new Ic(),
			'launcher' => new Launcher(),
			'porthole' => new Porthole(),
			'shell' => new Shell(),
			'tank' => new Tank(),
			'wires' => new Wires(),
		);
	}

	public function status(Writer $w) {
		$w->writeINcolor("Parts ready:\n", "\033[0;33;m");
		foreach ($this->parts as $key => $value) {
			if ($this->parts[$key]->exist) {
				$w->writeINcolor(" -> ", "\033[0;35;m");
				$w->writeINcolor(lcfirst($key) . PHP_EOL, "\033[0;32;m");
			}
		}
		$w->writeINcolor("Parts to build:\n", "\033[0;33;m");
		foreach ($this->parts as $key => $value) {
			if (!$this->parts[$key]->exist) {
				$w->writeINcolor(" -> ", "\033[0;35;m");
				$w->writeINcolor(lcfirst($key) . PHP_EOL, "\033[0;31;m");
			}
		}
	}

	public function scheme(Writer $w, String $type) {
		if (array_key_exists($type, $this->parts)) {
			$r = '';
			$to_use = $this->parts[$type]->need;
			foreach ($to_use as $k) {
				if (!empty($r)) {
					$r .= '|';
				}
				$r .= $k;
			}
			$w->writeln(ucfirst($type). " => {$r}");
		} else {
			$w->writeln('There is no such spaceship module.');
		}
	}

	public function build(Writer $w, String $type, $resourceManager) {
		if (array_key_exists($type, $this->parts)) {
			if ($this->parts[$type]->exist) {
				$w->writeln('Attention! ' . ucfirst($type) . ' is ready.');
			} else if ($this->check($w, $this->parts[$type]->need, $resourceManager->resources)) {
				$this->parts[$type]->produce($resourceManager->resources);
				$w->write(ucfirst($type) . ' is ready!');
				if ($this->check2()) {
					$w->writeln(" => You won!");
					return 1;
				} else {
					$w->write("\n");
				}
			}
		} else {
			$w->writeln('There is no such spaceship module.');
		}
		return 0;
	}

	private function check(Writer $w, Array $to_use, $resources) {
		$r = '';
		foreach ($to_use as $k) {
			if ($k == 'ic' && $this->parts[$k]->exist)
				continue;
			if ($k == 'wires' && $this->parts[$k]->exist)
				continue;
			if ($k != 'ic' && $k != 'wires' && $resources[$k]->getAmount() > 0)
				continue;
			if (!empty($r)) {
				$r .= ',';
			}
			$r .= $k;
		}
		if (!empty($r)) {
			$w->writeln("Inventory should have: {$r}.");
			return 0;
		}
		return 1;
	}

	private function check2() {
		foreach ($this->parts as $key => $value) {
			if (!$this->parts[$key]->exist)
				return 0;
		}
		return 1;
	}
}
