<?php

namespace Mocktainer;

class UnmockableMethodArgumentException extends \Exception
{

	/** @var string */
	private $className;

	/** @var string */
	private $methodName;

	/** @var string */
	private $argumentName;

	public function __construct($className, $methodName, $argumentName)
	{
		parent::__construct(sprintf(
			'Argument "%s" of method %s::%s cannot be mocked',
			$argumentName,
			$className,
			$methodName
		));

		$this->className = $className;
		$this->methodName = $methodName;
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
	public function getMethodName()
	{
		return $this->methodName;
	}

	/**
	 * @return string
	 */
	public function getArgumentName()
	{
		return $this->argumentName;
	}

}
