<?php

namespace BinaryStudioAcademy\Game;

use BinaryStudioAcademy\Game\PartsManager;
use BinaryStudioAcademy\Game\ResourceManager;
use BinaryStudioAcademy\Game\Contracts\Io\Writer;

class GameWorld
{
	private $partsManager;
	private $resourceManager;

	public function __construct() {
		$this->partsManager = new PartsManager();
		$this->resourceManager = new ResourceManager();
	}

	public function inputProcess(Writer $w, $line) {
		if (!$line)
			exit(1);
		$command = explode(':', trim($line));
		switch ($command[0]) {
			case 'help':
				$w->writeINcolor("Use this commands to process the game:\n", "\033[0;33;m");
				$w->writeINcolor(" -> help\n" .
					" -> status\n" .
					" -> build:<spaceship_module>\n" .
					" -> scheme:<spaceship_module>\n" .
					" -> mine:<resource_name>\n" .
					" -> produce:<combined_resource>\n" .
					" -> exit\n", "\033[0;35;m");
				break;

			case 'status':
				$this->resourceManager->status($w);
				$this->partsManager->status($w);
				break;

			case 'build':
					if ($this->partsManager->build($w, (count($command) == 2 ? $command[1] : "unnamed"), $this->resourceManager)) {
						return 1;
					}
				break;

			case 'scheme':
				$this->partsManager->scheme($w, (count($command) == 2 ? $command[1] : "unnamed"));
				break;

			case 'mine':
				$this->resourceManager->mine($w, (count($command) == 2 ? $command[1] : "unnamed"));
				break;

			case 'produce':
				$this->resourceManager->produce($w, (count($command) == 2 ? $command[1] : "unnamed"));
				break;

			case 'exit':
				exit(1);

			default:
				$w->writeln("There is no command {$command[0]}");
				break;
		}
		return 0;
	}
}
