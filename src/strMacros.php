<?php

	use Illuminate\Support\Str;

	Str::macro('extract', function ($haystack, $delimiter, $length, $defaultValue = null, $appendOverflowing = false) {
		$absLength = abs($length);

		// explode string
		if ($appendOverflowing)
			$sp = explode($delimiter, $haystack, $absLength);
		else
			$sp = explode($delimiter, $haystack);

		$numParts = count($sp);

		if ($numParts == $absLength) {
			return $sp;
		}
		elseif ($numParts > $absLength) {
			return array_slice($sp, 0, $absLength);
		}
		elseif ($length > 0) {
			// pad right
			return array_pad($sp, $absLength, $defaultValue);
		}
		else {
			// pad left
			return array_merge(array_fill(0, $absLength - $numParts, $defaultValue), $sp);
		}
	});

	Str::macro('replaceLineBreaks', function (?string $subject, ?string $replace = ' ') {

		if ($subject === null)
			return null;

		return str_replace(["\r\n", "\r", "\n"], $replace, $subject);

	});


	Str::macro('cutEncoding', function (?string $string, int $maxBytes, string $targetEncoding): ?string {
		if ($string === null)
			return null;

		$appEncoding = mb_internal_encoding();

		if ($targetEncoding !== $appEncoding)
			$string = mb_convert_encoding($string, $targetEncoding, $appEncoding);

		$string = mb_strcut($string, 0, $maxBytes, $targetEncoding);

		// convert our truncated string back to application charset
		if ($targetEncoding !== $appEncoding)
			$string = mb_convert_encoding($string, $appEncoding, $targetEncoding);

		return $string;
	});

	Str::macro('isEmpty', function (?string $value): bool {
		return trim($value) === '';
	});

	Str::macro('isNotEmpty', function (?string $value): bool {
		return trim($value) !== '';
	});

	Str::macro('ucFirstWords', function (?string $value, bool $forceLower = false, int $forceLowerMinLength = 0, string $splitByRegex = '[^\p{L}]+'): ?string {

		if ($value === null)
			return null;

		$wordData = preg_split('/(' . $splitByRegex . ')/u', $value, -1, PREG_SPLIT_OFFSET_CAPTURE);

		$segments = [];
		$lastPos  = 0;
		foreach ($wordData as $curr) {

			// add chars before current word
			$segments[] = substr($value, $lastPos, $curr[1] - $lastPos);

			// extract first char and rest
			$firstChar = Str::substr($curr[0], 0, 1);
			$rest      = Str::substr($curr[0], 1);

			// convert to upper/lower case
			$segments[] = Str::upper($firstChar) . ($forceLower && Str::length($curr[0]) >= $forceLowerMinLength ?
					Str::lower($rest) :
					$rest
				);

			// set last pos behind current word
			$lastPos = $curr[1] + strlen($curr[0]);
		}

		$segments[] = substr($value, $lastPos);

		return implode('', $segments);
	});

	Str::macro('repairInvalidUnicodeSequences', function (?string $str, string $replacement = "\u{FFFD}"): ?string {
		if ($str === null)
			return null;

		$ret = htmlspecialchars($str, ENT_DISALLOWED | ENT_SUBSTITUTE);

		if ($replacement !== "\u{FFFD}")
			$ret = str_replace("\u{FFFD}", $replacement, $ret);

		$ret = htmlspecialchars_decode($ret);

		return $ret;
	});

	Str::macro('limitMax', function (?string $value, int $limit = 100, string $end = '...'): ?string {

		if ($value === null)
			return null;

		if (mb_strwidth($value, 'UTF-8') <= $limit)
			return $value;

		return mb_strimwidth($value, 0, $limit - mb_strwidth($end, 'UTF-8'), '', 'UTF-8') . $end;
	});

	Str::macro('cast', function ($value) {

		if (is_iterable($value)) {
			$ret = [];
			foreach ($value as $item) {
				$ret[] = (string)$item;
			}

			return $ret;
		}
		else {
			$value = (string)$value;
		}

		return $value;
	});