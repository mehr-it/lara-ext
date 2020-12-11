<?php


	namespace MehrItLaraExtTest\Cases\Helper;


	use MehrItLaraExtTest\Cases\TestCase;

	class TypeNameTest extends TestCase
	{

		public function testTypeName() {

			$this->assertSame('null', type_name(null));
			$this->assertSame('string', type_name('string'));
			$this->assertSame('double', type_name(1.2));
			$this->assertSame('integer', type_name(1));
			$this->assertSame('boolean', type_name(true));
			$this->assertSame('array', type_name([]));
			$this->assertSame('resource', type_name(fopen('php://stdin', 'r')));
			$this->assertSame(static::class, type_name($this));

		}

	}