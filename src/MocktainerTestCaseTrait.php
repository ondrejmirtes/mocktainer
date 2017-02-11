<?php declare(strict_types = 1);

namespace Mocktainer;

trait MocktainerTestCaseTrait
{

	/** @var \Mocktainer\Mocktainer */
	private $mocktainer;

	public function getMocktainer(): Mocktainer
	{
		if ($this->mocktainer === null) {
			$this->mocktainer = new Mocktainer($this);
		}

		return $this->mocktainer;
	}

}
