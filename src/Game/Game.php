<?php

namespace BinaryStudioAcademy\Game;

use BinaryStudioAcademy\Game\GameWorld;
use BinaryStudioAcademy\Game\Contracts\Io\Reader;
use BinaryStudioAcademy\Game\Contracts\Io\Writer;

class Game
{
	private $inputLine;
	private $gameWorld;

	public function __construct() {
		$this->gameWorld = new GameWorld();
	}

	public function start(Reader $reader, Writer $writer): void {
		$this->greetings($writer);
		while (true) {
			$writer->writeINcolor("What will be your next command?..\n", "\033[0;33;m");
			$this->inputLine = $this->getInput($reader);
			if ($this->gameWorld->inputProcess($writer, $this->inputLine)) {
				break ;
			}
		}
	}

	public function run(Reader $reader, Writer $writer): void {
		$this->inputLine = $this->getInput($reader);
		$this->gameWorld->inputProcess($writer, $this->inputLine);
	}

	private function greetings(Writer $writer) {
		$writer->writeINcolor("Welcome in the game ", "\033[0;33;m");
		$writer->writeINcolor("\"Spaceship Constructor\"", "\033[0;36;m");
		$writer->writeINcolor("!\nHere you can create your own spaceship but there are some rules.\nUse ", "\033[0;33;m");
		$writer->writeINcolor("'help'", "\033[0;35;m");
		$writer->writeINcolor(" command if you don't know what to do next. Good Luck!\n", "\033[0;33;m");
	}

	private function getInput(Reader $reader) {
		return $reader->read();
	}
}
