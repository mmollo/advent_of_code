<?php

$input = file(__DIR__ . '/input');
$input = array_map(function ($line) {
    return explode(',', rtrim($line));
}, $input);

/*$input = [
    ['R8','U5','L5','D3'],
    ['U7','R6','D4','L4']
];*/


/*$input = [
    ['R75','D30','R83','U83','L12','D49','R71','U7','L72'],
    ['U62','R66','U55','R34','D71','R55','D58','R83']
];*/

/*$input = [
    ['R98','U47','R26','D63','R33','U87','L62','D20','R33','U53','R51'],
    ['U98','R91','D20','R16','D67','R40','U7','R15','U6','R7'],
];*/



$grids = [];
foreach ($input as $j => $wire) {
    $x = 0;
    $y = 0;
    $step = 0;
    foreach ($wire as $move) {
        $direction = $move[0];
        $amount = (int)substr($move, 1);

        if ('U' === $direction) {
            $h = 0;
            $v = 1;
        } elseif ('D' === $direction) {
            $h = 0;
            $v = -1;
        } elseif ('R' === $direction) {
            $h = 1;
            $v = 0;
        } elseif ('L' === $direction) {
            $h = -1;
            $v = 0;
        } else {
            die('off');
        }
        for ($i = 0 ; $i < $amount ; $i++) {
            $x += $h;
            $y += $v;
            $grids[$j]["$x:$y"] = ++$step;
        }
    }
}

$intersections = array_intersect(array_keys($grids[0]), array_keys($grids[1]));

$part1 = min(array_map(function ($x) {
    list($x, $y) = explode(':', $x);
    return abs($x) + abs($y);
}, $intersections));

echo "Part 1 : $part1\n";

$part2 = min(array_map(function ($x) use ($grids) {
    return $grids[0][$x] + $grids[1][$x];
}, $intersections));

echo "Part 2 : $part2\n";
