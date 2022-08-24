<?php

function adj($input, string $dot) {
	[$x, $y] = explode(':', $dot);
	
	$adj = array_map(fn($x) => implode(':', $x), [
		[$x-1, $y], [$x+1, $y],
		[$x, $y-1], [$x, $y+1],
	]);
	
	$o = array_filter($adj, function($dot) use ($input) {
		return array_key_exists($dot, $input);
	}); 
	
	
	return $o;
}

function array_min_pop(&$array) {

	$min_dist = +INF;
	$min_i = 0;
	$o = '';
	foreach($array as $i => [$node, $dist]) {		
		if($dist < $min_dist) {
			$min_dist = $dist;
			$o = $node;
			$min_i = $i;
		} 
	}

	unset($array[$min_i]);

	return [$o, $dist];
}

function mindist($array, $el) {
	$array[$el] ??= +INF;
	return $array[$el];
}
function a($input) {
	$h = $w = (int)sqrt(count($input));
	
	$from = '0:0';
	$to = implode(':', [$h - 1, $w -1]);
	
	$q = [[$from, $input[$from]]];
	$dists = [
		$from => $input[$from]
	];
	
	$visited = [];
	
	
	$i = 0;
	while(count($q) && 1) {
		echo "Loop " . ++$i . "\n-----\n\n";
		[$node, $dist] = array_min_pop($q);
		echo "At $node with $dist\n";
		

		if ($node == $to) return $dist;
		if (in_array($node, $visited)) continue;
		$visited[] = $node;
		
		foreach(adj($input, $node) as $adj) {
			echo "Adj $adj\n";
			if(in_array($adj, $visited)) continue;
			
			$newdist = $dist + $input[$adj];
			
			if($newdist < mindist($dists, $adj)) {
				$mindists[$adj] = $newdist;
				
				$q[] = [$adj, $newdist];
			}
		}
		
	}
	
}

$input = [];
foreach(explode("\n", rtrim(file_get_contents('./sample'))) as $x => $row) {
	foreach(str_split($row) as $y => $v) {
		$input["$x:$y"] = $v;
	}
}

echo a($input) . PHP_EOL;
