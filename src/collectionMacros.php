<?php

	use Illuminate\Support\Collection;

	Collection::macro('diffBy', function ($items, callable $compareFn) {
		return new static(array_udiff($this->items, $this->getArrayableItems($items), $compareFn));
	});

	Collection::macro('diffAssocBy', function ($items, callable $valueCompareFunc, callable $keyCompareFunc = null) {
		if ($keyCompareFunc)
			return new static(array_udiff_uassoc($this->items, $this->getArrayableItems($items), $valueCompareFunc, $keyCompareFunc));
		else
			return new static(array_udiff_assoc($this->items, $this->getArrayableItems($items), $valueCompareFunc));
	});

	Collection::macro('sortCallback', function (callable $compareFn, $keepKeys = false, $desc = false) {
		$items = $this->items;

		if ($desc) {
			$comparator = function ($a, $b) use ($compareFn) {
				return -1 * call_user_func($compareFn, $a, $b);
			};
		}
		else {
			$comparator = $compareFn;
		}

		// sort
		$keepKeys ? uasort($items, $comparator) : usort($items, $comparator);


		return new static($items);
	});

	Collection::macro('sortCallbackDesc', function (callable $compareFn, $keepKeys = false) {
		return $this->sortCallback($compareFn, $keepKeys, true);
	});