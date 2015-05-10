<?php

namespace Mocktainer;

class Mocktainer
{

	/** @var \PHPUnit_Framework_TestCase */
	private $testCase;

	public function __construct(\PHPUnit_Framework_TestCase $testCase)
	{
		$this->testCase = $testCase;
	}

	/**
	 * @param string $className
	 * @param mixed[] $constructorArguments
	 */
	public function create($className, array $constructorArguments = [])
	{
		if (!class_exists($className)) {
			throw new \Mocktainer\ClassNotFoundException($className);
		}

		$classReflection = new \ReflectionClass($className);
		$constructorReflection = $classReflection->getConstructor();
		$constructorArgumentsToCall = [];

		foreach ($this->getConstructorParameters($constructorReflection) as $name => $parameter) {
			if (isset($constructorArguments[$name])) {
				$constructorArgumentsToCall[] = $constructorArguments[$name];
				unset($constructorArguments[$name]);
			} elseif ($parameter->isDefaultValueAvailable()) {
				$constructorArgumentsToCall[] = $parameter->getDefaultValue();
			} else {
				$constructorArgumentsToCall[] = $this->getArgumentMock($className, $name, $parameter);
			}
		}

		if (count($constructorArguments) > 0) {
			throw new \Mocktainer\UnknownConstructorArgumentsException($className, $constructorArguments);
		}

		return $classReflection->newInstanceArgs($constructorArgumentsToCall);
	}

	/**
	 * @param string $className
	 * @param string $argumentName
	 * @param \ReflectionParameter $parameter
	 * @return mixed
	 */
	private function getArgumentMock($className, $argumentName, \ReflectionParameter $parameter)
	{
		if ($parameter->getClass() !== null) {
			return $this->testCase->getMockBuilder($parameter->getClass()->name)
				->disableOriginalConstructor()
				->getMock();
		}

		throw new \Mocktainer\UnmockableConstructorArgumentException($className, $argumentName);
	}

	/**
	 * @param \ReflectionMethod $constructorReflection
	 * @return \ReflectionParameter[]
	 */
	private function getConstructorParameters(\ReflectionMethod $constructorReflection)
	{
		$parameters = [];
		foreach ($constructorReflection->getParameters() as $parameter) {
			$parameters[$parameter->name] = $parameter;
		}

		return $parameters;
	}

}
