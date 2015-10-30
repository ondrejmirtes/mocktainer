<?php

namespace Mocktainer;

class UnknownMethodArgumentsException extends \Exception
{

	/** @var string */
	private $className;

	/** @var string */
	private $methodName;

	/** @var mixed[] */
	private $arguments;

	/**
	 * @param string $className
	 * @param string $methodName
	 * @param mixed[] $arguments name(string) => value(mixed)
	 */
	public function __construct($className, $methodName, array $arguments)
	{
		parent::__construct(sprintf(
			'Passed unknown arguments for method %s::%s: %s',
			$className,
			$methodName,
			implode(', ', array_keys($arguments))
		));

		$this->className = $className;
		$this->methodName = $methodName;
		$this->arguments = $arguments;
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
	 * @return mixed[]
	 */
	public function getArguments()
	{
		return $this->arguments;
	}

}
