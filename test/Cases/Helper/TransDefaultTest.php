<?php


	namespace MehrItLaraExtTest\Cases\Helper;


	use MehrItLaraExtTest\Cases\TestCase;

	class TransDefaultTest extends TestCase
	{

		public function testTranslationExisting() {

			trans()->addLines(
				[
					'test.key1' => 'value 1',
					'test.key2' => 'value :replaced',
				],
				app()->getLocale()
			);
			trans()->addLines(
				[
					'test.key1' => 'dk 1',
				],
				'dk'
			);

			$this->assertSame('value 1',trans_default('test.key1'));
			$this->assertSame('value 2', trans_default('test.key2', null, ['replaced' => '2']));
			$this->assertSame('dk 1', trans_default('test.key1', null, [], 'dk'));
		}

		public function testTranslationMissing() {


			$this->assertSame(null, trans_default('test.key1missing'));
			$this->assertSame('default 1', trans_default('test.key1missing', 'default 1'));
			$this->assertSame(null, trans_default('test.key2missing',  null, ['replaced' => '2']));
			$this->assertSame('default 2', trans_default('test.key2missing', 'default 2', ['replaced' => '2']));

			trans()->addLines(
				[
					'test.key3missing' => 'valueFromAppLocale 1',
				],
				app()->getLocale()
			);
			$this->assertSame('valueFromAppLocale 1', trans_default('test.key3missing', null, [], 'dk'));
			$this->assertSame('valueFromAppLocale 1', trans_default('test.key3missing', 'default 1', [], 'dk'));
			$this->assertSame('default 1', trans_default('test.key3missingEvenInAppLocale', 'default 1', [], 'dk'));
		}

	}