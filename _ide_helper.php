<?php
	/**
	 * A helper file for Laravel, to provide autocomplete information to your IDE
	 *
	 */

	namespace {
		exit("This file should not be included, only analyzed by your IDE");
	}

	namespace Illuminate\Support {

		use ArrayAccess;
		use Generator;
		use Iterator;
		use IteratorAggregate;
		use Traversable;

		class Collection
		{

			/**
			 * Get the items in the collection that are not present in the given items. It uses a custom comparator function
			 *
			 * @param mixed $items The items
			 * @param callable $compareFn The comparator function
			 * @return static
			 */
			public function diffBy($items, callable $compareFn) {

			}

			/**
			 * Get the items in the collection whose keys and values are not present in the given items. It uses custom comparator functions
			 *
			 * @param mixed $items The items
			 * @param callable $valueCompareFunc The value compare function
			 * @param callable|null $keyCompareFunc The key compare function. If not passed no custom function is used for key comparision
			 * @return static
			 */
			public function diffAssocBy($items, callable $valueCompareFunc, callable $keyCompareFunc = null) {

			}

			/**
			 * Sort the collection using given comparator function
			 * @param callable $compareFn The comparator function
			 * @param bool $keepKeys True to maintain keys
			 * @param bool $desc True to sort descending. Else false.
			 * @return static
			 */
			public function sortCallback(callable $compareFn, $keepKeys = false, $desc = false) {

			}

			/**
			 * Sort the collection in descending order using given comparator function
			 * @param callable $compareFn The comparator function
			 * @param bool $keepKeys True to maintain keys
			 * @return static
			 */
			public function sortCallbackDesc(callable $compareFn, $keepKeys = false) {

			}

		}

		class Str {
			/**
			 * Extracts values using a given delimiter. The resulting array will always have the given length
			 * @param string $haystack The haystack
			 * @param string $delimiter The delimiter
			 * @param int $length The number of elements in the return array. If positive the resulting array is left aligned. If negative the resulting array is right aligned.
			 * @param null $defaultValue The default value for the array elements
			 * @param bool $appendOverflowing If true, any overflowing values are appended to the last value using the original delimiter
			 * @return string[] The return array
			 */
			public static function extract($haystack, $delimiter, $length, $defaultValue = null, $appendOverflowing = false) : array {

			}

			/**
			 * Replaces the line breaks from the given string
			 * @param string|null $subject The subject
			 * @param string|null $replace The string to replace line breaks with
			 * @return string|null The string with all linebreaks replaced
			 */
			public static function replaceLineBreaks(?string $subject, ?string $replace = ' ') {

			}

		}

		/**
		 * Creates a buffer which is automatically flushed if it is full.
		 * @param int $size The buffer size. You may pass 0 or a negative value if the buffer should not be flushed automatically.
		 * @param callable $flushHandler Handler function which will be called on flush and receive the buffer contents as first parameter
		 * @param callable $collectionResolver Resolver for the underlying collection. This is called each time an empty collection is initialized and must return an
		 * empty collection instance. If omitted an array is used as underlying collection. Also a function name or a class name which is resolved via service container may be passed.
		 * @return \MehrIt\Buffer\FlushingBuffer
		 */
		function buffer($size, callable $flushHandler, $collectionResolver = null) { }

		/**
		 * Calls the given handler with chunks of the provided data. The last chunk's size may by less than the
		 * specified chunk size. This function "streams" the data using a flushing buffer internally.
		 * @param \Iterator|IteratorAggregate|ArrayAccess|[]|\Closure $data The source data
		 * @param int $size The chunk size
		 * @param callable $flushHandler Handler function which will receive the chunk data
		 * @param callable|string $collectionResolver Resolver for the underlying collection. This is called each time an empty collection is initialized and must return an
		 * empty collection instance. If omitted an array is used as underlying collection. Also a function name or a class name which is resolved via service container may be passed.
		 */
		function chunked($data, $size, callable $flushHandler, $collectionResolver = null) { }

		/**
		 * Calls the given callback with values of left and right collection joined by given field values. NULL values are never treated as equal.
		 * @param \Closure|Iterator|IteratorAggregate|[] $left The left side collection
		 * @param string $leftField The left side field to use for joining
		 * @param \Closure|Iterator|IteratorAggregate|[]|string|\Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $right The right side collection. This may also be
		 * a model class name or query builder instance for which queries are automatically executed
		 * @param string $rightField The right field to use for joining
		 * @param callable $callback The callback to be called with joined items. Will receive the left side item as first argument and the right side item as second
		 * @param bool $all True to return all matching right side items for each left side item. Else only the first matching item will be returned
		 */
		function joined($left, $leftField, $right, $rightField, callable $callback, $all = false) { }

		/**
		 * Iterates the given cursor and gets and generates an item for each element using "dot" notation
		 * @param Traversable|Iterator|IteratorAggregate|[]|ArrayAccess|Generator|function $cursor The data
		 * @param string|\Closure $field The field in "dot" notation or a closure returning the field value
		 * @param mixed $default The default value. This has no effect if a closure is passed as field
		 * @return Generator The generator
		 */
		function cursor_get($cursor, $field, $default = null) { }
	}