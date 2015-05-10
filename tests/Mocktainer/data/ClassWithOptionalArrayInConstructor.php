<?php

namespace Mocktainer;

class ClassWithOptionalArrayInConstructor
{

	/** @var \Mocktainer\FooService */
	public $fooService;

	/** @var mixed[] */
	public $options;

	/**
	 * @param \Mocktainer\FooService $fooService
	 * @param mixed[] $options
	 */
	public function __construct(FooService $fooService, array $options = [])
	{
		$this->fooService = $fooService;
		$this->options = $options;
	}

}
