<?php

namespace Mocktainer;

class FooService
{

	/** @var \BarService */
	public $barService;

	public function __construct(BarService $barService)
	{
		$this->barService = $barService;
	}

}
