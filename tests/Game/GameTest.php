<?php

namespace BinaryStudioAcademyTests\Game;

use BinaryStudioAcademy\Game\Game;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    private function commandsResponse(): array
    {
        return [
            ['build:random', 'There is no such spaceship module.'],
            ['mine:unnamed', 'No such resource.'],
            ['what?', 'There is no command what?'],
            ['build:shell', "Inventory should have: metal,fire."],
            ['produce:metal', 'You need to mine: iron,fire.'],
            ['mine:iron', 'Iron added to inventory.'],
            ['produce:metal', 'You need to mine: fire.'],
            ['mine:fire', 'Fire added to inventory.'],
            ['produce:metal', 'Metal added to inventory.'],
            ['build:shell', "Inventory should have: fire."],
            ['mine:fire', 'Fire added to inventory.'],
            ['build:shell', 'Shell is ready!'],
            ['build:porthole', 'Inventory should have: sand,fire.'],
            ['mine:fire', 'Fire added to inventory.'],
            ['build:porthole', 'Inventory should have: sand.'],
            ['mine:sand', 'Sand added to inventory.'],
            ['build:porthole', 'Porthole is ready!'],
            ['build:control_unit', 'Inventory should have: ic,wires.'],
            ['build:ic', 'Inventory should have: metal,silicon.'],
            ['mine:silicon', 'Silicon added to inventory.'],
            ['produce:metal', 'You need to mine: iron,fire.'],
            ['mine:iron', 'Iron added to inventory.'],
            ['produce:metal', 'You need to mine: fire.'],
            ['mine:fire', 'Fire added to inventory.'],
            ['produce:metal', 'Metal added to inventory.'],
            ['build:ic', 'Ic is ready!'],
            ['build:ic', 'Attention! Ic is ready.'],
            ['build:wires', 'Inventory should have: copper,fire.'],
            ['mine:copper', 'Copper added to inventory.'],
            ['mine:fire', 'Fire added to inventory.'],
            ['build:wires', 'Wires is ready!'],
            ['build:control_unit', 'Control_unit is ready!'],
            ['build:engine', 'Inventory should have: metal,carbon,fire.'],
            ['mine:fire', 'Fire added to inventory.'],
            ['mine:iron', 'Iron added to inventory.'],
            ['produce:metal', 'Metal added to inventory.'],
            ['mine:fire', 'Fire added to inventory.'],
            ['mine:carbon', 'Carbon added to inventory.'],
            ['build:engine', 'Engine is ready!'],
            ['build:launcher', 'Inventory should have: water,fire,fuel.'],
            ['mine:water', 'Water added to inventory.'],
            ['build:launcher', 'Inventory should have: fire,fuel.'],
            ['mine:fire', 'Fire added to inventory.'],
            ['mine:fuel', 'Fuel added to inventory.'],
            ['build:launcher', 'Launcher is ready!'],
            ['build:tank', 'Inventory should have: metal,fuel.'],
            ['mine:fuel', 'Fuel added to inventory.'],
            ['mine:fire', 'Fire added to inventory.'],
            ['mine:iron', 'Iron added to inventory.'],
            ['produce:metal', 'Metal added to inventory.'],
            ['build:tank', 'Tank is ready! => You won!'],
            ['scheme:tank', 'Tank => metal|fuel'],
            ['scheme:unknown', 'There is no such spaceship module.']
        ];
    }

    public function test_should_win_the_game()
    {
        $gameTester = new GameTester(new Game);

        // We're testing internal state here so loop is required.

        foreach ($this->commandsResponse() as [$command, $expected]) {
            $gameTester->run($command);

            $this->assertContains($expected, $gameTester->getOutput());
        }
    }
}
