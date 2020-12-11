<?php


	namespace MehrItLaraExtTest\Cases\Helper;


	use MehrItLaraExtTest\Cases\TestCase;

	class WithLocaleTest extends TestCase
	{

		public function testWithLocale() {

			$locale = app()->getLocale();
			if ($locale === 'nl')
				$this->markTestSkipped('Test requires app not to have default locale "nl"');

			$ret = new \stdClass();

			$this->assertSame($ret, with_locale('nl', function () use ($ret) {
				$this->assertSame('nl', app()->getLocale());

				return $ret;
			}));

			$this->assertSame($locale, app()->getLocale());

		}

		public function testWithLocale_throwingException() {

			$locale = app()->getLocale();
			if ($locale === 'nl')
				$this->markTestSkipped('Test requires app not to have default locale "nl"');

			try {
				with_locale('nl', function () {
					$this->assertSame('nl', app()->getLocale());

					throw new \Exception('test exception');
				});

				$this->fail('The expected exception was not thrown.');
			}
			catch (\Exception $ex) {

				$this->assertSame($locale, app()->getLocale());
			}


		}

	}