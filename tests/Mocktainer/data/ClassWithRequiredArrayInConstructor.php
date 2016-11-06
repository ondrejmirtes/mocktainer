<?php declare(strict_types = 1);

namespace Mocktainer;

class ClassWithRequiredArrayInConstructor
{

	/** @var \Mocktainer\FooService */
	public $fooService;

	/** @var mixed[] */
	public $options;

	/**
	 * @param \Mocktainer\FooService $fooService
	 * @param mixed[] $options
	 */
	public function __construct(FooService $fooService, array $options)
	{
		$this->fooService = $fooService;
		$this->options = $options;
	}

}
