<?php

namespace Mocktainer;

trait MocktainerTestCaseTrait
{

	/** @var \Mocktainer\Mocktainer */
	private $mocktainer;

	/**
	 * @return \Mocktainer\Mocktainer
	 */
	public function getMocktainer()
	{
		if ($this->mocktainer === null) {
			$this->mocktainer = new Mocktainer($this);
		}

		return $this->mocktainer;
	}

}
