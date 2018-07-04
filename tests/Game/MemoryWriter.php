<?php

namespace BinaryStudioAcademyTests\Game;


use BinaryStudioAcademy\Game\Contracts\Io\Writer;

class MemoryWriter implements Writer
{
	private $stream;

	public function __construct()
	{
		$this->stream = fopen('php://memory', 'w', false);
	}

	public function write(string $string)
	{
		fputs($this->stream, $string);
	}

	public function writeln(string $string)
	{
		fputs($this->stream, $string . PHP_EOL);
	}

	public function writeINcolor(string $string, string $color)
	{
		$coloredString = $color . $string . "\e[0m";
		fputs($this->stream, $coloredString);
	}

	public function getStream()
	{
		return $this->stream;
	}
}
