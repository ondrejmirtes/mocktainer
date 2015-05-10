<?php

namespace Mocktainer;

class ClassNotFoundException extends \Exception
{

	/** @var string */
	private $className;

	/**
	 * @param string $className
	 */
	public function __construct($className)
	{
		parent::__construct(sprintf('Class %s not found', $className));
		$this->className = $className;
	}

	/**
	 * @return string
	 */
	public function getClassName()
	{
		return $this->className;
	}

}
