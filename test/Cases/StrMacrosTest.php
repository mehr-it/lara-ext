<?php
	/**
	 * Created by PhpStorm.
	 * User: chris
	 * Date: 09.04.18
	 * Time: 11:55
	 */

	namespace MehrItLaraExtTest\Cases;


	use Illuminate\Support\Str;

	class StrMacrosTest extends TestCase
	{

		public function testExtractLeft() {

			[$vA, $vB, $vC] = Str::extract('a:b:c', ':', 3);

			$this->assertSame('a', $vA);
			$this->assertSame('b', $vB);
			$this->assertSame('c', $vC);
		}

		public function testExtractLeftMoreWanted() {

			[$vA, $vB, $vC, $vD, $vE] = Str::extract('a:b:c', ':', 5);

			$this->assertSame('a', $vA);
			$this->assertSame('b', $vB);
			$this->assertSame('c', $vC);
			$this->assertSame(null, $vD);
			$this->assertSame(null, $vE);
		}

		public function testExtractLeftLessWanted() {

			[$vA, $vB, $vC] = Str::extract('a:b:c:d', ':', 3);

			$this->assertSame('a', $vA);
			$this->assertSame('b', $vB);
			$this->assertSame('c', $vC);
		}

		public function testExtractLeftLessWantedAppend() {

			[$vA, $vB, $vC] = Str::extract('a:b:c:d', ':', 3, null, true);

			$this->assertSame('a', $vA);
			$this->assertSame('b', $vB);
			$this->assertSame('c:d', $vC);
		}

		public function testExtractLeftDefaultValue() {

			[$vA, $vB, $vC, $vD, $vE] = Str::extract('a:b:c', ':', 5, 'def');

			$this->assertSame('a', $vA);
			$this->assertSame('b', $vB);
			$this->assertSame('c', $vC);
			$this->assertSame('def', $vD);
			$this->assertSame('def', $vE);
		}


		public function testExtractRight() {

			[$vC, $vD, $vE] = Str::extract('a:b:c', ':', -3);

			$this->assertSame('a', $vC);
			$this->assertSame('b', $vD);
			$this->assertSame('c', $vE);
		}

		public function testExtractRightMoreWanted() {

			[$vA, $vB, $vC, $vD, $vE] = Str::extract('a:b:c', ':', -5);

			$this->assertSame(null, $vA);
			$this->assertSame(null, $vB);
			$this->assertSame('a', $vC);
			$this->assertSame('b', $vD);
			$this->assertSame('c', $vE);
		}

		public function testExtractRightLessWanted() {

			[$vC, $vD, $vE] = Str::extract('a:b:c:d', ':', -3);

			$this->assertSame('a', $vC);
			$this->assertSame('b', $vD);
			$this->assertSame('c', $vE);
		}

		public function testExtractRightLessWantedAppend() {

			[$vC, $vD, $vE] = Str::extract('a:b:c:d', ':', -3, null, true);

			$this->assertSame('a', $vC);
			$this->assertSame('b', $vD);
			$this->assertSame('c:d', $vE);
		}

		public function testExtractRightDefaultValue() {

			[$vA, $vB, $vC, $vD, $vE] = Str::extract('a:b:c', ':', -5, 'def');

			$this->assertSame('def', $vA);
			$this->assertSame('def', $vB);
			$this->assertSame('a', $vC);
			$this->assertSame('b', $vD);
			$this->assertSame('c', $vE);
		}

		public function testReplaceLineBreaks() {

			$this->assertSame('a b c d', Str::replaceLineBreaks("a\rb\r\nc\nd"));
		}

		public function testReplaceLineBreaks_withReplaceString() {

			$this->assertSame('a,b,c,d', Str::replaceLineBreaks("a\rb\r\nc\nd", ','));
		}

		public function testReplaceLineBreaks_withNullReplaceString() {

			$this->assertSame('abcd', Str::replaceLineBreaks("a\rb\r\nc\nd", null));
		}

		public function testReplaceLineBreaks_nullInput() {

			$this->assertSame(null, Str::replaceLineBreaks(null));
		}

		public function testUcFirstWords() {

			$this->assertSame('Busch Jaeger', Str::ucFirstWords('busch jaeger'));
			$this->assertSame('Busch-Jäger AG', Str::ucFirstWords('busch-jäger AG'));
			$this->assertSame('*;Busch--Jäger AG%$', Str::ucFirstWords('*;busch--jäger AG%$'));
			$this->assertSame('Busch', Str::ucFirstWords('busch'));
			$this->assertSame(null, Str::ucFirstWords(null));
			$this->assertSame('', Str::ucFirstWords(''));
			$this->assertSame('0', Str::ucFirstWords('0'));

			// force lower
			$this->assertSame('Busch Jaeger', Str::ucFirstWords('BUSCH JAEGER', true));
			$this->assertSame('Busch-Jäger Ag', Str::ucFirstWords('BUSCH-JÄGER AG', true));
			$this->assertSame('*;Busch--Jäger Ag%$', Str::ucFirstWords('*;BUSCH--JÄGER AG%$', true));
			$this->assertSame('Busch', Str::ucFirstWords('BUSCH', true));
			$this->assertSame(null, Str::ucFirstWords(null));
			$this->assertSame('', Str::ucFirstWords(''));
			$this->assertSame('0', Str::ucFirstWords('0'));

			// force lower with min
			$this->assertSame('Busch Jaeger', Str::ucFirstWords('BUSCH JAEGER', true, 4));
			$this->assertSame('Busch-Jäger AG', Str::ucFirstWords('BUSCH-JÄGER AG', true, 4));
			$this->assertSame('ABB', Str::ucFirstWords('ABB', true, 4));
			$this->assertSame('ABB Computer', Str::ucFirstWords('ABB COMPUTER', true, 4));
			$this->assertSame('ABB Computer', Str::ucFirstWords('aBB cOMPUTER', true, 4));


		}

		public function testCast() {

			$this->assertSame('', Str::cast(null));
			$this->assertSame('0', Str::cast(0));
			$this->assertSame('0.45', Str::cast(0.45));
			$this->assertSame('1', Str::cast('1'));
			$this->assertSame(['0', '5.6', '1'], Str::cast([0, 5.6, '1']));

		}

		public function testCutEncoding_iso8859_15() {

			config()->set('database.wawi_db_charset', 'ISO-8859-15');

			$this->assertEquals('xÄÖÜ', Str::cutEncoding('xÄÖÜ', 4, 'ISO-8859-15'));
			$this->assertEquals('?xÄÖ', Str::cutEncoding('ҨxÄÖÜ', 4, 'ISO-8859-15'));
			$this->assertEquals('€xÄÖ', Str::cutEncoding('€xÄÖÜ', 4, 'ISO-8859-15'));

		}

		public function testCutEncoding_utf8() {

			config()->set('database.wawi_db_charset', 'UTF-8');

			$this->assertEquals('XDcf', Str::cutEncoding('XDcf', 4, 'UTF-8'));
			$this->assertEquals('xÄ', Str::cutEncoding('xÄÖÜ', 4, 'UTF-8'));
			$this->assertEquals('Ҩx', Str::cutEncoding('ҨxÄÖÜ', 4, 'UTF-8'));
			$this->assertEquals('€', Str::cutEncoding('€ÄÖÜ', 4, 'UTF-8'));

		}

		public function testEmptyString() {

			$this->assertSame(true, Str::isEmpty(null));
			$this->assertSame(true, Str::isEmpty(''));
			$this->assertSame(true, Str::isEmpty(' '));
			$this->assertSame(false, Str::isEmpty('0'));
			$this->assertSame(false, Str::isEmpty('false'));
			$this->assertSame(false, Str::isEmpty('null'));
			$this->assertSame(false, Str::isEmpty('abc'));

		}

		public function testNotEmptyString() {

			$this->assertSame(false, Str::isNotEmpty(null));
			$this->assertSame(false, Str::isNotEmpty(''));
			$this->assertSame(false, Str::isNotEmpty(' '));
			$this->assertSame(true, Str::isNotEmpty('0'));
			$this->assertSame(true, Str::isNotEmpty('false'));
			$this->assertSame(true, Str::isNotEmpty('null'));
			$this->assertSame(true, Str::isNotEmpty('abc'));

		}

		public function testReplaceInvalidUnicodeSequences() {

			$this->assertSame("ab\u{FFFD}cd", Str::repairInvalidUnicodeSequences("ab\xC2\x96cd"));
			$this->assertSame("ab?cd", Str::repairInvalidUnicodeSequences("ab\xC2\x96cd", '?'));
			$this->assertSame("abcd", Str::repairInvalidUnicodeSequences("ab\xC2\x96cd", ''));
			$this->assertSame("ab cd", Str::repairInvalidUnicodeSequences("ab\xC2\x96cd", ' '));

		}

		public function testLimitMax() {

			$this->assertSame('abcd', Str::limitMax('abcd', 5));
			$this->assertSame('abcde', Str::limitMax('abcde', 5));
			$this->assertSame('ab...', Str::limitMax('abcdefg', 5));
			$this->assertSame('Äb...', Str::limitMax('Äbcdefg', 5));
			$this->assertSame(null, Str::limitMax(null, 5));
			$this->assertSame('abcXX', Str::limitMax('abcdefg', 5, 'XX'));
			$this->assertSame('a ...', Str::limitMax('a bdefg', 5));

		}
	}