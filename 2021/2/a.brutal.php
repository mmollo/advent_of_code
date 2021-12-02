<?php

function a(array $input): int
{
    list($x, $y) = array_reduce(
        $input,
        function ($a, $c) {
            switch ($c[0]) {
                case 'forward':
                    $a[0] += $c[1];
                    break;
                case 'up':
                    $a[1] -= $c[1];
                    break;
                case 'down':
                    $a[1] += $c[1];
                    break;
            }
            return $a;
        },
        [0, 0]
    );

    return $x * $y;
}

function b(array $input): int
{
    list($x, $y, $aim) = array_reduce(
        $input,
        function ($a, $c) {
            switch ($c[0]) {
                case 'forward':
                    $a[0] += $c[1];
                    $a[1] += $c[1] * $a[2];
                    break;
                case 'up':
                    $a[2] -= $c[1];
                    break;
                case 'down':
                    $a[2] += $c[1];
                    break;
            }
            return $a;
        },
        [0, 0, 0]
    );
    return $x * $y;
}

$input = explode("\n", rtrim(file_get_contents('input')));
$input = array_map(function ($str) {
    return explode(" ", $str);
}, $input);

echo a($input) . PHP_EOL;
echo b($input) . PHP_EOL;
