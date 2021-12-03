<?php

$input = explode("\n", rtrim(file_get_contents('./input')));
$input = array_map(fn($x) => str_split($x), $input);

function gamma(array $input) : array {
    $c = [];
    foreach($input as $line) {
        foreach($line as $i => $v) {
            $c[$i] ??= ['0' => 0, '1' => 0];
            $c[$i][$v]++;
        }
    }

    $c = array_map(fn($x) => $x[1] == $x[0] ? '2' : (string)(int)($x[1] > $x[0]), $c);
    return $c;
}

function epsilon(array $input) : array {
    $g = gamma($input);
    return array_map(fn($x) => '2' == $x ? $x : abs($x - 1), $g);
}

function a(array $input) : int {
    $g = gamma($input);
    $e = epsilon($input);
    $g = bindec(implode('', $g));
    $e = bindec(implode('', $e));

    return $g * $e;
}

function scrub(array $input, string $path, callable $c) : int {

    $i = 0;
    while(count($input) > 1) {
        $d = array_map(fn($x) => implode('', $x), $input);
        $v = $c($input)[$i];

        if($v == '2') $v = $path;
        $input = array_filter($input, fn($x) => ($x[$i] == $v));
        $i++;
    }

    return bindec(implode('', array_shift($input)));
}

function b(array $input) : int {
    $co = scrub($input, '0', 'epsilon');
    $o2 = scrub($input, '1',  'gamma');

    return $co * $o2;
}

echo a($input) . PHP_EOL;
echo b($input) . PHP_EOL;
