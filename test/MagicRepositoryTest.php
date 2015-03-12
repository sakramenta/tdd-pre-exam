<?php

require __DIR__ . '/../src/MagicRepository.php';

class MagicRepositoryTest extends PHPUnit_Framework_TestCase
{
	public function testGetAbrakadabra()
	{
		$repository = new MagicRepository();

		$this->assertEquals('abrakadabra', $repository->getAbrakadabra());
	}
}
