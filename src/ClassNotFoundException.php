<?php declare(strict_types = 1);

namespace Mocktainer;

class ClassNotFoundException extends \Exception
{

	/** @var string */
	private $className;

	public function __construct(string $className)
	{
		parent::__construct(sprintf('Class %s not found', $className));
		$this->className = $className;
	}

	public function getClassName(): string
	{
		return $this->className;
	}

}
