<?php

namespace Mocktainer;

class FooService
{

	/** @var \Mocktainer\BarService */
	public $barService;

	public function __construct(BarService $barService)
	{
		$this->barService = $barService;
	}

}
