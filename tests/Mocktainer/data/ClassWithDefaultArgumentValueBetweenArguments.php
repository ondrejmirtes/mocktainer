<?php declare(strict_types = 1);

namespace Mocktainer;

class ClassWithDefaultArgumentValueBetweenArguments
{

	/** @var \Mocktainer\FooService */
	public $fooService;

	/** @var mixed[] */
	public $options;

	/** @var \Mocktainer\BarService */
	public $barService;

	/**
	 * @param \Mocktainer\FooService $fooService
	 * @param mixed[] $options
	 * @param \Mocktainer\BarService $barService
	 */
	public function __construct(FooService $fooService, array $options = ['foobar' => 'foobarValue'], BarService $barService)
	{
		$this->fooService = $fooService;
		$this->options = $options;
		$this->barService = $barService;
	}

}
