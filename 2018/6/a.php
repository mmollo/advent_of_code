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

function shortest($point, array $list)
{
    $selected = [];
    $min = +INF;
    foreach ($list as $i => $target) {
        $dist = distance($point, $target);
        if (0 === $dist) {
            $selected = [$i];
            $min = $dist;
            continue;
        }
        if ($dist < $min) {
            $selected = [$i];
            $min = $dist;
            continue;
        }
        if ($dist === $min) {
            $selected[] = $i;
            continue;
        }
    }

    if (1 === count($selected)) {
        return $selected[0];
    }
    return null;
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

$areas = $inf = [];
for ($i = $d ; $i <= $b ; $i++) {
    for ($j = $a ; $j <= $c ; $j++) {
        $shortest = shortest([$j,$i], $input);
        if (is_null($shortest)) {
            continue;
        }
        if (!isset($areas[$shortest])) {
            $areas[$shortest] = 0;
        }
        $areas[$shortest]++;
        
        if (!isset($inf[$shortest]) && ($j == $d || $j == $b || $i == $a || $i == $c)) {
            $inf[$shortest] = true;
        }
    }
}

$max = 0;
foreach ($areas as $i => $surface) {
    if (isset($inf[$i])) {
        continue;
    }
    if ($surface > $max) {
        $max = $surface;
    }
}

echo $max;
