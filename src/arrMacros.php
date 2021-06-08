<?php
	
	namespace MehrIt\LaraExt;
	
	require_once __DIR__ . '/arrMacrosUtil.php';

	use Illuminate\Support\Arr;
	
	
	Arr::macro('hasSameKeysAndValues', function(array $a, array $b, bool $strict = false) {
		return arrayKeyValuesAreSame($a, $b, $strict);
	});