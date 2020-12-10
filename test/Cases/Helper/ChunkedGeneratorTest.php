<?php


	namespace MehrItLaraExtTest\Cases\Helper;


	use Illuminate\Support\Collection;
	use MehrItLaraExtTest\Cases\TestCase;

	class ChunkedGeneratorTest extends TestCase
	{
		public function testConsume() {

			$invokedArgs = [];
			$fn          = function ($arr) use (&$invokedArgs) {
				$invokedArgs[] = $arr;

				foreach ($arr as $curr) {
					yield strtoupper($curr);
				}
			};

			$res = chunked_generator(['a', 'b', 'c', 'd', 'e'], 2, $fn);

			// nothing should be invoked yet
			$this->assertEquals([], $invokedArgs);

			$this->assertEquals(['A', 'B', 'C', 'D', 'E'], iterator_to_array($res));
			$this->assertInstanceOf(\Generator::class, $res);

			// now we expect 3 iterations
			$this->assertEquals([['a', 'b'], ['c', 'd'], ['e']], $invokedArgs);

		}

		public function testConsume_fromIterator() {

			$invokedArgs = [];
			$fn          = function ($arr) use (&$invokedArgs) {
				$invokedArgs[] = $arr;

				foreach ($arr as $curr) {
					yield strtoupper($curr);
				}
			};

			$res = chunked_generator(new \ArrayIterator(['a', 'b', 'c', 'd', 'e']), 2, $fn);

			// nothing should be invoked yet
			$this->assertEquals([], $invokedArgs);

			$this->assertEquals(['A', 'B', 'C', 'D', 'E'], iterator_to_array($res));
			$this->assertInstanceOf(\Generator::class, $res);

			// now we expect 3 iterations
			$this->assertEquals([['a', 'b'], ['c', 'd'], ['e']], $invokedArgs);

		}

		public function testConsume_fromEmptyIterator() {

			$invokedArgs = [];
			$fn          = function ($arr) use (&$invokedArgs) {
				$invokedArgs[] = $arr;

				foreach ($arr as $curr) {
					yield strtoupper($curr);
				}
			};

			$res = chunked_generator(new \EmptyIterator(), 2, $fn);

			// nothing should be invoked yet
			$this->assertEquals([], $invokedArgs);

			$this->assertEquals([], iterator_to_array($res));
			$this->assertInstanceOf(\Generator::class, $res);

			// now we expect 0 iterations
			$this->assertEquals([], $invokedArgs);

		}

		public function testConsume_fromClosure() {

			$invokedArgs = [];
			$fn          = function ($arr) use (&$invokedArgs) {
				$invokedArgs[] = $arr;

				foreach ($arr as $curr) {
					yield strtoupper($curr);
				}
			};

			$res = chunked_generator(function () {
				return ['a', 'b', 'c', 'd', 'e'];
			}, 2, $fn);

			// nothing should be invoked yet
			$this->assertEquals([], $invokedArgs);

			$this->assertEquals(['A', 'B', 'C', 'D', 'E'], iterator_to_array($res));
			$this->assertInstanceOf(\Generator::class, $res);

			// now we expect 3 iterations
			$this->assertEquals([['a', 'b'], ['c', 'd'], ['e']], $invokedArgs);

		}

		public function testConsume_callbackReturningEmptyIterator() {

			$invokedArgs = [];
			$fn          = function ($arr) use (&$invokedArgs) {
				$invokedArgs[] = $arr;

				if (false)
					yield 'A';
			};

			$res = chunked_generator(new \ArrayIterator(['a', 'b', 'c', 'd', 'e']), 2, $fn);

			// nothing should be invoked yet
			$this->assertEquals([], $invokedArgs);

			$this->assertEquals([], iterator_to_array($res));
			$this->assertInstanceOf(\Generator::class, $res);

			// now we expect 3 iterations
			$this->assertEquals([['a', 'b'], ['c', 'd'], ['e']], $invokedArgs);

		}

		public function testConsume_callbackReturningSometimesEmptyIterator() {

			$invokedArgs = [];
			$fn          = function ($arr) use (&$invokedArgs) {
				$invokedArgs[] = $arr;

				if (count($invokedArgs) != 2) {
					foreach ($arr as $curr) {
						yield strtoupper($curr);
					}
				}
			};

			$res = chunked_generator(new \ArrayIterator(['a', 'b', 'c', 'd', 'e']), 2, $fn);

			// nothing should be invoked yet
			$this->assertEquals([], $invokedArgs);

			$this->assertEquals(['A', 'B', 'E'], iterator_to_array($res));
			$this->assertInstanceOf(\Generator::class, $res);

			// now we expect 3 iterations
			$this->assertEquals([['a', 'b'], ['c', 'd'], ['e']], $invokedArgs);

		}

		public function testConsume_withCustomCollection_fromClass() {

			$invokedArgs = [];
			$fn          = function ($arr) use (&$invokedArgs) {
				$this->assertInstanceOf(Collection::class, $arr);

				$invokedArgs[] = $arr->toArray();

				foreach ($arr as $curr) {
					yield strtoupper($curr);
				}
			};

			$res = chunked_generator(function () {
				return ['a', 'b', 'c', 'd', 'e'];
			}, 2, $fn, Collection::class);

			// nothing should be invoked yet
			$this->assertEquals([], $invokedArgs);

			$this->assertEquals(['A', 'B', 'C', 'D', 'E'], iterator_to_array($res));
			$this->assertInstanceOf(\Generator::class, $res);

			// now we expect 3 iterations
			$this->assertEquals([['a', 'b'], ['c', 'd'], ['e']], $invokedArgs);

		}

		public function testConsume_withCustomCollection_fromResolverFunction() {

			$invokedArgs = [];
			$fn          = function ($arr) use (&$invokedArgs) {
				$this->assertInstanceOf(Collection::class, $arr);

				$invokedArgs[] = $arr->toArray();

				foreach ($arr as $curr) {
					yield strtoupper($curr);
				}
			};

			$res = chunked_generator(function () {
				return ['a', 'b', 'c', 'd', 'e'];
			}, 2, $fn, function () {
				return new Collection();
			});

			// nothing should be invoked yet
			$this->assertEquals([], $invokedArgs);

			$this->assertEquals(['A', 'B', 'C', 'D', 'E'], iterator_to_array($res));
			$this->assertInstanceOf(\Generator::class, $res);

			// now we expect 3 iterations
			$this->assertEquals([['a', 'b'], ['c', 'd'], ['e']], $invokedArgs);

		}
	}