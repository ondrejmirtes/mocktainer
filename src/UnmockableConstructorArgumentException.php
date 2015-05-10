<?php

namespace Mocktainer;

class UnmockableConstructorArgumentException extends \Exception
{

	/** @var string */
	private $className;

	/** @var string */
	private $argumentName;

	public function __construct($className, $argumentName)
	{
		parent::__construct(sprintf(
			'Constructor argument "%s" of class %s cannot be mocked',
			$argumentName,
			$className
		));

		$this->className = $className;
		$this->argumentName = $argumentName;
	}

	/**
	 * @return string
	 */
	public function getClassName()
	{
		return $this->className;
	}

	/**
	 * @return string
	 */
	public function getArgumentName()
	{
		return $this->argumentName;
	}

}
