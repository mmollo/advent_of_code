<?php

function a($input){
	$f=$d=$u=0;
	foreach($input as $l) {${$l[0][0]}+=$l[1];}
	return $f*($d-$u);	
}

function b($input){
	$a=$x=$y=0;
	foreach($input as $l) {
		$v = $l[0][0];
		if('d' == $v) $a+=$l[1];
		elseif('u' == $v) $a-=$l[1];
		else {$x+=$l[1];$y+=$l[1]*$a;}
	}
    return $x*$y;
}

$input = explode("\n", rtrim(file_get_contents('input')));
$input = array_map(function ($str) {
    return explode(" ", $str);
}, $input);

echo a($input) . PHP_EOL;
echo b($input) . PHP_EOL;
