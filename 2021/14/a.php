<?php

function split_pairs($string) {
	$o = [];
	for($i = 0 ; $i < strlen($string) - 1 ; $i++) {
		$o[] = substr($string, $i, 2);
	}
	
	return $o;
}

function step($_pairs, $rules) {
	
	$pairs = $score = [];
	foreach($_pairs as $pair => $count) {
		echo "Pair $pair scores $count\n";
		
		$a = $pair[0];
		$b = $pair[1];
		$c = $rules[$pair];
		echo "$a + $b = $c\n";
		
		
		$score[$a] ??= 0;
		echo "Add $count to $a (" . $score[$a] . ") -> ";
		$score[$a] += $count;
		echo $score[$a] . "\n";
		$score[$c] ??= 0;
		echo "Add $count to $c (" . $score[$c] . ") -> ";
		$score[$c] += $count;
		echo 	$score[$c] . "\n";
		foreach([$a . $c, $c . $b] as $p) {
			$pairs[$p] ??= 0;
			$pairs[$p] += $count;
		}
		
		
	}
	$b = $pair[1];
	$score[$b] ??= 0;
	echo "Add $count to $b (" . $score[$b] . ") -> ";
	$score[$b] += $count;
	echo $score[$b] . "\n";
		
	//var_dump($pairs);
	var_dump($score);
	
	return [$pairs, $score];
}

function process($pairs, $rules, $steps) {
	for($i = 0 ; $i < $steps ; $i++)  {
	echo "Step $i\n";
		[$pairs, $score] = step($pairs, $rules);
}

	print_r($score);
	return max($score) - min($score);
}

function a($pairs, $rules) {
	return process($pairs, $rules, 10);
}

function b($pairs, $rules) {
	return process($pairs, $rules, 40);
}


$input = rtrim(file_get_contents('./sample'));
[$template, $rules] = explode("\n\n", $input);

$pairs = array_count_values(split_pairs($template));

$rules = array_reduce(explode("\n", $rules), function($a, $p) {
	[$k, $v] = explode(' -> ', $p);
	$a[$k] = $v;
	return $a;
}, []);


function c($template, $rules) {
}
//echo a($pairs, $rules) . PHP_EOL;
echo c($template, $rules) . PHP_EOL;
//echo b($pairs, $rules) . PHP_EOL;

