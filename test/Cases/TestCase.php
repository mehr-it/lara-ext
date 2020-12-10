<?php


	namespace MehrItLaraExtTest\Cases;


	use MehrIt\LaraExt\Provider\LaraExtServiceProvider;
	use Orchestra\Testbench\TestCase as OrchestraTestCase;

	abstract class TestCase extends OrchestraTestCase
	{

		/**
		 * Load package service provider
		 * @param \Illuminate\Foundation\Application $app
		 * @return array
		 */
		protected function getPackageProviders($app) {
			return [
				LaraExtServiceProvider::class,
			];
		}
	}