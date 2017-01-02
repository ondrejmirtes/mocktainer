<?php declare(strict_types = 1);

namespace Mocktainer;

class FunctionalityOverviewTest extends \Mocktainer\TestCase
{

	public function testMockedClassNotFound()
	{
		try {
			$this->getMocktainer()->create('Mocktainer\Nonexistent');
			$this->fail();
		} catch (\Mocktainer\ClassNotFoundException $e) {
			$this->assertSame('Class Mocktainer\Nonexistent not found', $e->getMessage());
			$this->assertSame('Mocktainer\Nonexistent', $e->getClassName());
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

	public function testPassNonexistentConstructorArgument()
	{
		try {
			$this->getMocktainer()->create(FooService::class, [
				'barService' => new BarService(),
				'baz' => 'bazValue',
			]);
			$this->fail();
		} catch (\Mocktainer\UnknownConstructorArgumentsException $e) {
			$this->assertSame('Passed unknown constructor arguments for class Mocktainer\FooService: baz', $e->getMessage());
			$this->assertSame(FooService::class, $e->getClassName());
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

	public function testRequireUnmockableConstructorArgument()
	{
		try {
			$this->getMocktainer()->create(ClassWithRequiredArrayInConstructor::class);
			$this->fail();
		} catch (\Mocktainer\UnmockableConstructorArgumentException $e) {
			$this->assertSame('Constructor argument "options" of class Mocktainer\ClassWithRequiredArrayInConstructor cannot be mocked', $e->getMessage());
			$this->assertSame(ClassWithRequiredArrayInConstructor::class, $e->getClassName());
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
