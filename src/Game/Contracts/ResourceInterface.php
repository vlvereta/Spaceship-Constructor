<?php

namespace BinaryStudioAcademy\Game\Contracts;

interface ResourceInterface
{
	public function use();
	public function produce();
	public function getAmount();
}
