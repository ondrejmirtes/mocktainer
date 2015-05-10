Mocktainer
=====================

[![Build Status](https://travis-ci.org/ondrejmirtes/mocktainer.svg)](https://travis-ci.org/ondrejmirtes/mocktainer)

Tired of passing mocked dependencies you don't care about to classes under tests?

Is this code familiar to you?

```php
$foo1 = $this->getMockBuilder(Foo1::class)
	->disableOriginalConstructor()
	->getMock();
$foo2 = $this->getMockBuilder(Foo2::class)
	->disableOriginalConstructor()
	->getMock();
$foo3 = $this->getMockBuilder(Foo3::class)
	->disableOriginalConstructor()
	->getMock();
$foo4 = $this->getMockBuilder(Foo4::class)
	->disableOriginalConstructor()
	->getMock();
$interestingDependency = $this->getMock(Foo5::class);
$interestingDependency->expects($this->once())
	->method('getAwesome')
	->getMock();

// public function __construct(Foo1 $foo1, Foo2 $foo2, Foo3 $foo3, Foo4 $foo4, Foo5 $foo5)
$bar = new Bar($foo1, $foo2, $foo3, $foo4, $interestingDependency);
```

With **Mocktainer**, you can reduce the above code to this:

```php
$interestingDependency = $this->getMock(Foo5::class);
$interestingDependency->expects($this->once())
	->method('getAwesome')
	->getMock();

$this->getMocktainer()->getMock(Bar::class, ['foo5' => $interestingDependency]);
```

Other mockable constructor arguments will be mocked using `MockBuilder` and `disableOriginalConstructor()`.
