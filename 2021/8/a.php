<?php

function sig(string $str1, string $str2) : string {
    $ar1 = str_split(str_replace(' ', '', $str1));
    $ar2 = str_split(str_replace(' ', '', $str2));
    $a = count(array_diff($ar1, $ar2));
    $b = count(array_diff($ar2, $ar1));
    $c = count(array_intersect($ar1, $ar2));

    $sig = implode(':', [$a, $b, $c]);

    return $sig;
}

function defs2sigs(array $defs) : array {
    $sigs = [];
    foreach($defs as $i => $s1) {
        foreach($defs as $j => $s2) {
            if($i === $j) continue;
            $sig = sig($s1, $s2);
            $sigs[$sig] ??= [];
            $sigs[$sig][] = [$i, $j];
        }
    }
    return $sigs;
}

function str_diff(string $str1, string $str2) : string {
    $ar1 = str_split($str1);
    $ar2 = str_split($str2);

    return implode('', array_diff(array_merge($ar1, $ar2), array_intersect($ar1, $ar2)));
}
function str_sort(string $str) : string {
    $d = str_split($str);
    sort($d);
    return implode('', $d);
}

function a(array $input) : int {
    return array_reduce($input, function($acc, $x) {
        return $acc + count(array_filter($x[1], fn($y) => in_array(strlen($y), [2,3,4,7])));
    }, 0);
}

function b(array $input) : int {
    $defs = [
        0 => 'abc efg', // 6
        1 =>   'c  f',  // 2
        2 => 'a cde g', // 5
        3 => 'a cd fg', // 5
        4 => ' bcd f',  // 3
        5 => 'ab d fg', // 5
        6 => 'ab defg', // 6
        7 => 'a c  f',  // 3
        8 => 'abcdefg', // 7
        9 => 'abcd fg'  // 6
    ];
    $sigs = defs2sigs($defs);

    $total = 0;
    foreach($input as $l) {

        $segments = array_map(fn($x) => str_sort($x), $l[0]);
        $wires = array_map(fn($x) => str_sort($x), $l[1]);

        $num = [];
        foreach($segments as $i => $s1) {
            foreach($segments as $j => $s2) {
                if($i === $j) continue;
                $sig = sig($s1, $s2);
                if(!array_key_exists($sig, $sigs)) continue;
                if(count($sigs[$sig]) > 1) continue;
                [$n1, $n2] = $sigs[$sig][0];
                $num[$n1] = $s1;
                $num[$n2] = $s2;
            }
        }
        $segments = array_diff($segments, $num);
        foreach($segments as $s) {
            if(strlen($s) === 5) $num[5] = $s;
            else $num[0] = $s;
        }

        $num = array_flip($num);

        $total += (int)implode('', array_map(fn($x) => $num[$x], $wires));
    }
    return $total;
}

$input = explode("\n", rtrim(file_get_contents('./input')));
$input = array_map(function($x) {
    [$a, $b] = explode(' | ', $x);
    return [
        explode(' ', $a),
        explode(' ', $b)
    ];
}, $input);


echo a($input) . PHP_EOL;
echo b($input) . PHP_EOL;
