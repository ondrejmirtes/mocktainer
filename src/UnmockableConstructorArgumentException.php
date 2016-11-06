<?php declare(strict_types = 1);

namespace Mocktainer;

class UnmockableConstructorArgumentException extends \Exception
{

	/** @var string */
	private $className;

	/** @var string */
	private $argumentName;

	public function __construct(string $className, string $argumentName)
	{
		parent::__construct(sprintf(
			'Constructor argument "%s" of class %s cannot be mocked',
			$argumentName,
			$className
		));

		$this->className = $className;
		$this->argumentName = $argumentName;
	}

	public function getClassName(): string
	{
		return $this->className;
	}

	public function getArgumentName(): string
	{
		return $this->argumentName;
	}

}
