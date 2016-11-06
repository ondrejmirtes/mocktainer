<?php declare(strict_types = 1);

namespace Mocktainer;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{

	use MocktainerTestCaseTrait;

}
