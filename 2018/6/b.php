<?php
$input = [];
while ($line = rtrim(fgets(STDIN))) {
    $input[] = $line;
}

$input = array_map(function ($point) {
    list($x, $y) = explode(", ", $point);
    return [(int)$x, (int)$y];
}, $input);

function distance($a, $b)
{
    return abs($a[0] - $b[0]) + abs($a[1] - $b[1]);
}

function sum_distance($point, array $input)
{
    return array_reduce($input, function ($acc, $p) use ($point) {
        return $acc + distance($p, $point);
    }, 0);
}

function edges(array $input)
{
    $c = $b = -INF;
    $d = $a = +INF;
    foreach ($input as $point) {
        list($x, $y) = $point;
        if ($x < $d) {
            $d = $x;
        }
        if ($x > $b) {
            $b = $x;
        }
        if ($y < $a) {
            $a = $y;
        }
        if ($y > $c) {
            $c = $y;
        }
    }
    return [$a,$b,$c,$d];
}

list($a, $b, $c, $d) = edges($input);

$area = 0;
for ($i = $d ; $i <= $b ; $i++) {
    for ($j = $a ; $j <= $c ; $j++) {
        $sum_dist = sum_distance([$i,$j], $input);
        if ($sum_dist < 10000) {
            $area++;
        }
    }
}

echo $area;
