<?php

$input = rtrim(file_get_contents(__DIR__ . '/input'));

function A(string $input) : int {
	$layers = str_split($input, 25 * 6);

	$layers = array_map(function($layer) {
		return [
			substr_count($layer, '0'),
			substr_count($layer, '1'),
			substr_count($layer, '2'),
		];
	}, $layers);

	$min0 = [null, PHP_INT_MAX];
	foreach($layers as $i => $layer) {
		if($layer[0] < $min0[1]) {
			$min0 = [$i, $layer[0]];
		}
	}

	$layer = $layers[$min0[0]];

	return $layer[1] * $layer[2];
}

function B(string $input, int $rows = 25, int $cols = 6) {
	$layers = str_split($input, $rows * $cols);
	
	$image = array_fill(0, $rows * $cols, 2);
	foreach($layers as $layer) {
		for($i = 0 ; $i < strlen($layer) ; $i++) {
			if(2 !== $image[$i]) continue;
			$image[$i] = (int)$layer[$i];
		}
	}
	return str_replace('0', ' ', implode("\n", (str_split(implode('', $image), $rows))));
}

$result = A($input);
echo "Part 1 : $result" . PHP_EOL;

$result = B($input);
echo "Part 2 : \n$result\n" . PHP_EOL;

