<?php

namespace Mocktainer;

class FunctionalityOverviewTest extends \Mocktainer\TestCase
{

	public function testMockedClassNotFound()
	{
		try {
			$this->getMocktainer()->create(Nonexistent::class);
			$this->fail();
		} catch (\Mocktainer\ClassNotFoundException $e) {
			$this->assertSame('Class Mocktainer\Nonexistent not found', $e->getMessage());
			$this->assertSame(Nonexistent::class, $e->getClassName());
		}
	}

	public function testCreateServiceWithAllMocks()
	{
		$fooService = $this->getMocktainer()->create(FooService::class);
		$this->assertInstanceOf(FooService::class, $fooService);
		$barService = $fooService->barService;
		$this->assertInstanceOf(BarService::class, $barService);
		$this->assertContains('Mock_', get_class($barService));
	}

	public function testCallMethodWithAllMocks()
	{
		$fooService = $this->getMocktainer()->create(FooService::class);
		$this->assertInstanceOf(FooService::class, $fooService);
		$this->getMocktainer()->call($fooService, 'setBazService');
		$bazService = $fooService->bazService;
		$this->assertInstanceOf(BazService::class, $bazService);
		$this->assertContains('Mock_', get_class($bazService));
	}

	public function testPassNonexistentConstructorArgument()
	{
		try {
			$this->getMocktainer()->create(FooService::class, [
				'barService' => new BarService(),
				'baz' => 'bazValue',
			]);
			$this->fail();
		} catch (\Mocktainer\UnknownMethodArgumentsException $e) {
			$this->assertSame('Passed unknown arguments for method Mocktainer\FooService::__construct: baz', $e->getMessage());
			$this->assertSame(FooService::class, $e->getClassName());
			$this->assertSame('__construct', $e->getMethodName());
			$this->assertSame(['baz' => 'bazValue'], $e->getArguments());
		}
	}

	public function testPassConstructorArgumentToConstructor()
	{
		$barService = new BarService();
		$fooService = $this->getMocktainer()->create(FooService::class, [
			'barService' => $barService,
		]);
		$this->assertInstanceOf(FooService::class, $fooService);
		$this->assertSame($barService, $fooService->barService);
	}

	public function testCallWithMethodArgument()
	{
		$barService = new BarService();
		$fooService = $this->getMocktainer()->create(FooService::class, [
			'barService' => $barService,
		]);
		$bazService = new BazService();
		$this->getMocktainer()->call($fooService, 'setBazService', [
			'bazService' => $bazService,
		]);
		$this->assertInstanceOf(FooService::class, $fooService);
		$this->assertSame($bazService, $fooService->bazService);
	}

	public function testRequireUnmockableConstructorArgument()
	{
		try {
			$this->getMocktainer()->create(ClassWithRequiredArrayInConstructor::class);
			$this->fail();
		} catch (\Mocktainer\UnmockableMethodArgumentException $e) {
			$this->assertSame('Argument "options" of method Mocktainer\ClassWithRequiredArrayInConstructor::__construct cannot be mocked', $e->getMessage());
			$this->assertSame(ClassWithRequiredArrayInConstructor::class, $e->getClassName());
			$this->assertSame('__construct', $e->getMethodName());
			$this->assertSame('options', $e->getArgumentName());
		}
	}

	public function testBeQuietAboutOptionalConstructorArgument()
	{
		$mock = $this->getMocktainer()->create(ClassWithOptionalArrayInConstructor::class);
		$this->assertInstanceOf(ClassWithOptionalArrayInConstructor::class, $mock);
		$fooService = $mock->fooService;
		$this->assertInstanceOf(FooService::class, $fooService);
		$this->assertContains('Mock_', get_class($fooService));
		$this->assertSame([], $mock->options);
	}

	public function testUseDefaultConstructorArgument()
	{
		$mock = $this->getMocktainer()->create(ClassWithDefaultArgumentValueBetweenArguments::class);
		$this->assertInstanceOf(ClassWithDefaultArgumentValueBetweenArguments::class, $mock);
		$fooService = $mock->fooService;
		$this->assertInstanceOf(FooService::class, $fooService);
		$this->assertContains('Mock_', get_class($fooService));
		$this->assertSame(['foobar' => 'foobarValue'], $mock->options);
		$barService = $mock->barService;
		$this->assertInstanceOf(BarService::class, $barService);
		$this->assertContains('Mock_', get_class($barService));
	}

}
