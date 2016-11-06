<?php declare(strict_types = 1);

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
