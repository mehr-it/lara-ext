<?php


	namespace MehrItLaraExtTest\Cases;


	use Illuminate\Support\Arr;

	class ArrMacrosTest extends TestCase
	{

		public function testHasSameKeysAndValues() {

			$this->assertSame(true, Arr::hasSameKeysAndValues([], []));
			$this->assertSame(true, Arr::hasSameKeysAndValues([], [], true));
			
			$this->assertSame(true, Arr::hasSameKeysAndValues([1, 2, 3], [1, 2, 3]));
			$this->assertSame(true, Arr::hasSameKeysAndValues([1, 2, 3], [1, 2, 3], true));
						
			$this->assertSame(false, Arr::hasSameKeysAndValues([1, 2, 3], [3, 2, 1]));
			$this->assertSame(false, Arr::hasSameKeysAndValues([1, 2, 3], [3, 2, 1], true));
			
			$this->assertSame(false, Arr::hasSameKeysAndValues([1, 2, 3], [1, 2, 4]));
			$this->assertSame(false, Arr::hasSameKeysAndValues([1, 2, 3], [1, 2, 4], true));
			
			$this->assertSame(true, Arr::hasSameKeysAndValues([1, 2, 3], ['1', 2, '3']));
			$this->assertSame(false, Arr::hasSameKeysAndValues([1, 2, 3], ['3', 2, '1']));
			$this->assertSame(false, Arr::hasSameKeysAndValues([1, 2, 3], ['1', 2, '3'], true));
			$this->assertSame(false, Arr::hasSameKeysAndValues([1, 2, 3], ['3', 2, '1'], true));

			$this->assertSame(true, Arr::hasSameKeysAndValues([1, 2, [3, [4, 5]]], [1, 2, [3, [4, 5]]]));
			$this->assertSame(true, Arr::hasSameKeysAndValues([1, 2, [3, [4, 5]]], [1, 2, [3, [4, 5]]], true));
			
			$this->assertSame(false, Arr::hasSameKeysAndValues([1, 2, [3, [4, 5]]], [1, 2, [0, [4, 5]]]));
			$this->assertSame(false, Arr::hasSameKeysAndValues([1, 2, [3, [4, 5]]], [1, 2, [0, [4, 5]]], true));

			$this->assertSame(false, Arr::hasSameKeysAndValues([1, 2, [3, [4, 5]]], [1, 2, [3, [4], 0]]));
			$this->assertSame(false, Arr::hasSameKeysAndValues([1, 2, [3, [4, 5]]], [1, 2, [3, [4, 0]]], true));

			$this->assertSame(false, Arr::hasSameKeysAndValues([1, 2, 3], [1, 2]));
			$this->assertSame(false, Arr::hasSameKeysAndValues([1, 2, 3], [1, 2], true));

			$this->assertSame(false, Arr::hasSameKeysAndValues([1, 2], [1, 2, 3]));
			$this->assertSame(false, Arr::hasSameKeysAndValues([1, 2], [1, 2, 3], true));
			
			$this->assertSame(false, Arr::hasSameKeysAndValues([[1, 2, 3]], [[1, 2]]));
			$this->assertSame(false, Arr::hasSameKeysAndValues([[1, 2, 3]], [[1, 2]], true));
			
			$this->assertSame(false, Arr::hasSameKeysAndValues([[1, 2]], [[1, 2, 3]]));
			$this->assertSame(false, Arr::hasSameKeysAndValues([[1, 2]], [[1, 2, 3]], true));
			
			$this->assertSame(true, Arr::hasSameKeysAndValues(['a' => 1, 'b' => null, 'x' => 'string', 'z' => false], ['z' => false, 'x' => 'string',  'b' => null, 'a' => 1]));
			$this->assertSame(true, Arr::hasSameKeysAndValues(['a' => 1, 'b' => null, 'x' => 'string', 'z' => false], ['z' => false, 'x' => 'string',  'b' => null, 'a' => 1], true));
			
			$this->assertSame(true, Arr::hasSameKeysAndValues(['a' => 0, 'b' => null, 'x' => 'string', 'z' => false], ['z' => 0, 'x' => 'string',  'b' => null, 'a' => false]));
			$this->assertSame(false, Arr::hasSameKeysAndValues(['a' => 0, 'b' => null, 'x' => 'string', 'z' => false], ['z' => 0, 'x' => 'string',  'b' => null, 'a' => false], true));

			$this->assertSame(true, Arr::hasSameKeysAndValues(['d' => ['e' => ['a' => 1, 'b' => null, 'x' => 'string', 'z' => false]]], ['d' => ['e' => ['z' => false, 'x' => 'string', 'b' => null, 'a' => 1]]]));
			$this->assertSame(true, Arr::hasSameKeysAndValues(['d' => ['e' => ['a' => 1, 'b' => null, 'x' => 'string', 'z' => false]]], ['d' => ['e' => ['z' => false, 'x' => 'string', 'b' => null, 'a' => 1]]], true));
			
			$this->assertSame(true, Arr::hasSameKeysAndValues(['d' => ['e' => ['a' => 0, 'b' => null, 'x' => 'string', 'z' => false]]], ['d' => ['e' => ['z' => 0, 'x' => 'string', 'b' => null, 'a' => false]]]));
			$this->assertSame(false, Arr::hasSameKeysAndValues(['d' => ['e' => ['a' => 0, 'b' => null, 'x' => 'string', 'z' => false]]], ['d' => ['e' => ['z' => 0, 'x' => 'string', 'b' => null, 'a' => false]]], true));
			
			$this->assertSame(false, Arr::hasSameKeysAndValues(['a' => 1, 'b' => 2, 'c' => 2], ['a' => 1, 'b' => 2]));
			$this->assertSame(false, Arr::hasSameKeysAndValues(['a' => 1, 'b' => 2, 'c' => 2], ['a' => 1, 'b' => 2], true));

			$this->assertSame(false, Arr::hasSameKeysAndValues(['a' => 1, 'b' => 2], ['a' => 1, 'b' => 2, 'c' => 2]));
			$this->assertSame(false, Arr::hasSameKeysAndValues(['a' => 1, 'b' => 2], ['a' => 1, 'b' => 2, 'c' => 2], true));
			
			$this->assertSame(false, Arr::hasSameKeysAndValues([['a' => 1, 'b' => 2, 'c' => 2]], [['a' => 1, 'b' => 2]]));
			$this->assertSame(false, Arr::hasSameKeysAndValues([['a' => 1, 'b' => 2, 'c' => 2]], [['a' => 1, 'b' => 2]], true));

			$this->assertSame(false, Arr::hasSameKeysAndValues([['a' => 1, 'b' => 2]], [['a' => 1, 'b' => 2, 'c' => 2]]));
			$this->assertSame(false, Arr::hasSameKeysAndValues([['a' => 1, 'b' => 2]], [['a' => 1, 'b' => 2, 'c' => 2]], true));

			
		}
	}