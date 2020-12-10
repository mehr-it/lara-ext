<?php

	namespace MehrItLaraExtTest\Cases;


	use ItsMieger\Obj\Contracts\Comparable;
	use ItsMieger\Obj\Obj;
	use ItsMieger\Obj\ObjectHelper;
	use MehrItLaraExtTest\Cases\TestCase;

	class CollectionMacrosTest extends TestCase
	{

		public function testDiffBy() {
			$collection = collect(['a', 'b', 'c']);

			$res = $collection->diffBy(['a', 'b', 'c'], function($a, $b) {

				switch($a . $b) {
					case 'bb':
						return 0;
					default:
						return 1;
				}
			});

			$this->assertSame([0 => 'a', 2 => 'c'], $res->all());
		}

		public function testDiffAssocBy() {
			$collection = collect([
				'x' => 'a',
				'y' => 'b',
				'z' => 'c'
			]);

			$res = $collection->diffAssocBy(['x' => 'a', 'y' => 'bb', 'zz' => 'c'], function() {
				return 0;
			}, function() use ($collection) {
				return 0;
			});

			$this->assertSame([], $res->all());
		}

		public function testDiffAssocByOnlyKeyCompareFn() {
			$collection = collect([
				'x' => 'a',
				'y' => 'b',
				'z' => 'c'
			]);

			$res = $collection->diffAssocBy(['x' => 'a', 'y' => 'bb', 'zz' => 'c'], function() {
				return 0;
			});

			$this->assertSame(['z' => 'c'], $res->all());
		}

		public function testSortCallback() {
			$a = new \stdClass();
			$a->key = 'z';

			$b      = new \stdClass();
			$b->key = 'x';

			$c      = new \stdClass();
			$c->key = 'y';

			$collection = collect([$a, $b, $c]);

			$res = $collection->sortCallback(function($a, $b) {
				return $a->key <=> $b->key;
			});
			$this->assertSame([$b, $c, $a], $res->all());
		}

		public function testSortCallbackReverse() {
			$a = new \stdClass();
			$a->key = 'z';

			$b      = new \stdClass();
			$b->key = 'x';

			$c      = new \stdClass();
			$c->key = 'y';

			$collection = collect([$a, $b, $c]);

			$res = $collection->sortCallback(function($a, $b) {
				return $a->key <=> $b->key;
			}, false, true);
			$this->assertSame([$a, $c, $b], $res->all());
		}

		public function testSortCallbackKeepKeys() {
			$a      = new \stdClass();
			$a->key = 'z';

			$b      = new \stdClass();
			$b->key = 'x';

			$c      = new \stdClass();
			$c->key = 'y';

			$collection = collect([$a, $b, $c]);

			$res = $collection->sortCallback(function ($a, $b) {
				return $a->key <=> $b->key;
			}, true);
			$this->assertSame([1 => $b, 2 => $c, 0 => $a], $res->all());
		}

		public function testSortCallbackKeepKeysReverse() {
			$a      = new \stdClass();
			$a->key = 'z';

			$b      = new \stdClass();
			$b->key = 'x';

			$c      = new \stdClass();
			$c->key = 'y';

			$collection = collect([$a, $b, $c]);

			$res = $collection->sortCallback(function ($a, $b) {
				return $a->key <=> $b->key;
			}, true, true);
			$this->assertSame([0 => $a, 2 => $c, 1 => $b], $res->all());
		}

		public function testSortCallbackDesc() {
			$a      = new \stdClass();
			$a->key = 'z';

			$b      = new \stdClass();
			$b->key = 'x';

			$c      = new \stdClass();
			$c->key = 'y';

			$collection = collect([$a, $b, $c]);

			$res = $collection->sortCallbackDesc(function ($x, $y) {
				return $x->key <=> $y->key;
			});
			$this->assertSame([$a, $c, $b], $res->all());
		}

		public function testSortCallbackDescKeepKeys() {
			$a      = new \stdClass();
			$a->key = 'z';

			$b      = new \stdClass();
			$b->key = 'x';

			$c      = new \stdClass();
			$c->key = 'y';

			$collection = collect([$a, $b, $c]);

			$res = $collection->sortCallbackDesc(function ($x, $y) {
				return $x->key <=> $y->key;
			}, true);
			$this->assertSame([0 => $a, 2 => $c, 1 => $b], $res->all());
		}

	}