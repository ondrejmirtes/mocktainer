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
	 * @param mixed[] $methodArguments
	 * @return object
	 */
	public function create($className, array $methodArguments = [])
	{
		if (!class_exists($className)) {
			throw new \Mocktainer\ClassNotFoundException($className);
		}

		$classReflection = new \ReflectionClass($className);
		$methodArgumentsToCall = $this->completeMethodArguments($classReflection, '__construct', $methodArguments);

		return $classReflection->newInstanceArgs($methodArgumentsToCall);
	}

	/**
	 * @param object $object
	 * @param string $methodName
	 * @param mixed[] $methodArguments
	 */
	public function call($object, $methodName, array $methodArguments = [])
	{
		$classReflection = new \ReflectionClass($object);
		$methodArgumentsToCall = $this->completeMethodArguments($classReflection, $methodName, $methodArguments);

		call_user_func_array([$object, $methodName], $methodArgumentsToCall);
	}

	/**
	 * @param \ReflectionClass $classReflection
	 * @param string $methodName
	 * @param mixed[] $methodArguments
	 * @return \mixed[]
	 */
	private function completeMethodArguments(\ReflectionClass $classReflection, $methodName, array $methodArguments)
	{
		$methodReflection = $classReflection->getMethod($methodName);
		$methodArgumentsToCall = [];

		foreach ($this->getMethodParameters($methodReflection) as $name => $parameter) {
			if (isset($methodArguments[$name])) {
				$methodArgumentsToCall[] = $methodArguments[$name];
				unset($methodArguments[$name]);
			} elseif ($parameter->isDefaultValueAvailable()) {
				$methodArgumentsToCall[] = $parameter->getDefaultValue();
			} else {
				$methodArgumentsToCall[] = $this->getArgumentMock($parameter);
			}
		}

		if (count($methodArguments) > 0) {
			throw new \Mocktainer\UnknownMethodArgumentsException($classReflection->getName(), $methodName, $methodArguments);
		}

		return $methodArgumentsToCall;
	}

	/**
	 * @param \ReflectionParameter $parameter
	 * @return mixed
	 */
	private function getArgumentMock(\ReflectionParameter $parameter)
	{
		if ($parameter->getClass() !== null) {
			return $this->testCase->getMockBuilder($parameter->getClass()->getName())
				->disableOriginalConstructor()
				->getMock();
		}

		throw new \Mocktainer\UnmockableMethodArgumentException(
			$parameter->getDeclaringClass()->getName(),
			$parameter->getDeclaringFunction()->getName(),
			$parameter->getName()
		);
	}

	/**
	 * @param \ReflectionMethod $methodReflection
	 * @return \ReflectionParameter[]
	 */
	private function getMethodParameters(\ReflectionMethod $methodReflection)
	{
		$parameters = [];
		foreach ($methodReflection->getParameters() as $parameter) {
			$parameters[$parameter->name] = $parameter;
		}

		return $parameters;
	}

}
