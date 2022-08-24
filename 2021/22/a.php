<?php
function a($input) {
	$r = [];
	
	foreach($input as [$op, $x1, $x2, $y1, $y2, $z1, $z2]) {
		$x1 = min(max(-50, $x1), 50);
		$x2 = min(max(-50, $x2), 50);
		$y1 = min(max(-50, $y1), 50);
		$y2 = min(max(-50, $y2), 50);
		$z1 = min(max(-50, $z1), 50);
		$z2 = min(max(-50, $z2), 50);
		[$x1, $x2] = $x1 < $x2 ? [$x1, $x2] : [$x2, $x1];
		[$y1, $y2] = $y1 < $y2 ? [$y1, $y2] : [$y2, $y1];
		[$z1, $z2] = $z1 < $z2 ? [$z1, $z2] : [$z2, $z1];
		
		for($i = $x1 ; $i <= $x2 ; $i++) {
			for($j = $y1 ; $j <= $y2 ; $j++) {
				for($k = $z1 ; $k <= $z2 ; $k++) {
					$r["$i:$j;$k"] = $op;
				}	
			}	
		}
	}
	
	$n = 0;
	foreach($r as $v) {
		if($v) $n++;
	}
	
	
	
	
	
	return $n;
}





$input = explode("\n", rtrim(file_get_contents('./sample')));
$input = array_map(function($l) {
	[$op, $l] = explode(' ', $l);
	$op = $op == 'on' ? true : false;
	preg_match_all('/([0-9-]+)/', $l, $matches);
	return array_merge([$op], $matches[0]);
}, $input);


echo a($input) . PHP_EOL;
