<?php

	namespace MehrIt\LaraExt;
	
	function arrayKeyValuesAreSame(array &$a, array &$b, bool $strict): bool {


		foreach ($a as $key => &$aValue) {

			if (!array_key_exists($key, $b))
				return false;

			$bValue = &$b[$key];


			if (is_array($aValue) && is_array($bValue)) {
				// compare arrays recursively

				if (!arrayKeyValuesAreSame($aValue, $bValue, $strict))
					return false;
			}
			else if ($strict ? ($aValue !== $bValue) : ($aValue != $bValue)) {
				// use strict comparison if not comparing two arrays

				return false;
			}

		}

		foreach (array_keys($b) as $currKey) {
			if (!array_key_exists($currKey, $a))
				return false;
		}

		return true;
	}