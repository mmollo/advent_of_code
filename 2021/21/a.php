<?php
function move($p, $s) {
	return 1 +  ($p + $s - 1) % 10;
}

function a($p1, $p2, $max = 1000) {
	function dice($i = 1) {
		static $v = 1;
		$r = $v * $i + $i;
		$v += $i;
		return $r;
	}

	$n = $s1 = $s2 = 0;
	
	while(1) {
		$s1 += $p1 = move($p1, dice(3));
		$n += 3;
		if($s1 >= $max) return $n * $s2;
		$s2 += $p2 = move($p2, dice(3));
		$n += 3;
		if($s2 >= $max) return $n * $s1;
	}	
}

function b($p1, $p2, $max = 21) {
	$S = [];
	for($i = 1 ; $i <= 3; $i++) {
		for($j = 1 ; $j <= 3 ; $j++) {
			for($k = 1 ; $k <= 3; $k++) {
				$S[] = $i + $j + $k;
			}
		}
	}
	$S = array_count_values($S);
	
	$v1 = $v2 = 0;
	
	
	
}

$input = file_get_contents('./input');
preg_match_all('/([0-9])/', $input, $matches);
list($_a, $p1, $_b, $p2) = $matches[0];

echo a($p1, $p2) . PHP_EOL;
echo b($p1, $p2) . PHP_EOL;
