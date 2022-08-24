<?php


function nexp($n) {
	eval('$n = ' . $n . ';');
	
	return $n;
}

function nspl($n) {
}

function expect($a, $b) {
	if ($a !== $b) throw new Exception("Expected $b, got $a");
}

$test_nexp = [
	"[[[[[9,8],1],2],3],4]" => "[[[[0,9],2],3],4]"
];

foreach($test_nexp as $i => $o) expect(nexp($i), $o);
$input = explode("\n", rtrim(file_get_contents('./sample')));


