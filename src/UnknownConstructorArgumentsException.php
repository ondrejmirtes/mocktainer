<?php declare(strict_types = 1);

namespace Mocktainer;

class UnknownConstructorArgumentsException extends \Exception
{

	/** @var string */
	private $className;

	/** @var mixed[] */
	private $arguments;

	/**
	 * @param string $className
	 * @param mixed[] $arguments name(string) => value(mixed)
	 */
	public function __construct(string $className, array $arguments)
	{
		parent::__construct(sprintf(
			'Passed unknown constructor arguments for class %s: %s',
			$className,
			implode(', ', array_keys($arguments))
		));

		$this->className = $className;
		$this->arguments = $arguments;
	}

	public function getClassName(): string
	{
		return $this->className;
	}

	/**
	 * @return mixed[]
	 */
	public function getArguments(): array
	{
		return $this->arguments;
	}

}
