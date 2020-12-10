<?php
	/**
	 * Created by PhpStorm.
	 * User: chris
	 * Date: 18.12.18
	 * Time: 16:59
	 */

	namespace MehrItLaraExtTest\Cases\Helper;


	use MehrItLaraExtTest\Cases\TestCase;

	class MappedTest extends TestCase
	{

		public function testArray() {

			$data = ['a', 'b', 'c'];

			$ret = mapped($data, function($curr) {
				return strtoupper($curr);
			});

			$this->assertInstanceOf(\Generator::class, $ret);
			$this->assertEquals(['A', 'B', 'C'], iterator_to_array($ret));

		}

		public function testIterator() {

			$data = new \ArrayIterator(['a', 'b', 'c']);

			$ret = mapped($data, function($curr) {
				return strtoupper($curr);
			});

			$this->assertInstanceOf(\Generator::class, $ret);
			$this->assertEquals(['A', 'B', 'C'], iterator_to_array($ret));

		}

	}