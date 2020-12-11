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

			/**
			 * Ensures the given maximum byte length when string is converted to target encoding. The function
			 * converts the string to target charset, truncates it and converts ist back to application
			 * encoding.
			 * @param string|null $string The string
			 * @param int $maxBytes The maximum number of bytes
			 * @param string $targetEncoding The target encoding, which the string should be truncated for
			 * @return string|null The converted string
			 */
			public static function cutEncoding(?string $string, int $maxBytes, string $targetEncoding): ?string {

			}

			/**
			 * Returns if the given string is empty or only contains whitespace
			 * @param string|null $value The value
			 * @return bool True if string is empty. Else false.
			 */
			public static function isEmpty(?string $value): bool {

			}

			/**
			 * Returns if the given string is not empty and does not only contains whitespace
			 * @param string|null $value The value
			 * @return bool True if string is not empty. Else false.
			 */
			public static function isNotEmpty(?string $value): bool {

			}

			/**
			 * Converts the first letter of each word to uppercase
			 * @param string|null $value The string
			 * @param bool $forceLower True if to force any following word letters to be lowercase
			 * @param int $forceLowerMinLength Set the minimum length of words to force lowercase suffix for
			 * @param string $splitByRegex The regex to split the words. Anything not matching the regex will be considered as word
			 * @return string|null
			 */
			public static function ucFirstWords(?string $value, bool $forceLower = false, int $forceLowerMinLength = 0, string $splitByRegex = '[^\p{L}]+'): ?string {

			}

			/**
			 * Replaces invalid unicode sequences
			 * @param string|null $str The string
			 * @param string $replacement The replacement for invalid sequences
			 * @return string|null The string
			 */
			public static function repairInvalidUnicodeSequences(?string $str, string $replacement = "\u{FFFD}"): ?string {

			}

			/**
			 * Limits a string to the given max length
			 * @param string|null $value The value
			 * @param int $limit The max limit
			 * @param string $end The end in case of truncation
			 * @return string|null The truncated string
			 */
			public static function limitMax(?string $value, int $limit = 100, string $end = '...'): ?string {

			}

			/**
			 * Casts given value as string. If iterable is given, it's items are casted as string
			 * @param mixed $value The value
			 * @return string|string[] The casted value
			 */
			public static function cast($value) {

			}
		}
	}