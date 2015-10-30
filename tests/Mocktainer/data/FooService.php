<?php

namespace Mocktainer;

class FooService
{

	/** @var \Mocktainer\BarService */
	public $barService;

	/** @var \Mocktainer\BazService */
	public $bazService;

	public function __construct(BarService $barService)
	{
		$this->barService = $barService;
	}

	public function setBazService(BazService $bazService)
	{
		$this->bazService = $bazService;
	}

}
