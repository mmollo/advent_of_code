<?php

$input = [];
while($line = rtrim(fgets(STDIN))) {
    $input[] = str_split($line);
}

function run_map(array $map) {
    $out = [];
    foreach($map as $y => $row) {
        $out[$y] = [];
        foreach($row as $x => $cell) {
            $adjacent = count_adjacent($x, $y, $map);
            if('.' === $cell && $adjacent['|'] >= 3) {
                $cell = '|';
            } elseif('|' === $cell && $adjacent['#'] >= 3) {
                $cell = '#';
            } elseif('#' === $cell) {
                if($adjacent['#'] >=1 && $adjacent['|'] >= 1) {
                    $cell = '#';
                } else {
                    $cell = '.';
                }
            }
            $out[$y][$x] = $cell;
        }
    }

    return $out;
}

function count_adjacent(int $x, int $y, array $map) {
    $adjacent = array_count_values(adjacent($x, $y, $map));
    unset($adjacent['']);
    return array_merge(
        [
            '.' => 0,
            '|' => 0,
            '#' => 0
        ],
        $adjacent
    );
}
function adjacent(int $x, int $y, array $map) {
    return [
        at($map, $x-1, $y-1),
        at($map, $x, $y-1),
        at($map, $x+1, $y-1),

        at($map, $x-1, $y),
        at($map, $x+1, $y),

        at($map, $x-1, $y+1),
        at($map, $x, $y+1),
        at($map, $x+1, $y+1),
    ];
}

function at(array $map, int $x, int $y) {
    if(!isset($map[$y])) return '';
    if(!isset($map[$y][$x])) return '';
    return $map[$y][$x];
}

function display(array $map) {
    foreach($map as $y => $row) {
        foreach($row as $x => $cell) {
            echo $cell;
        }
        echo "\n";
    }
    echo "\n";
}

function count_map(array $map) {
    return array_reduce($map, function($acc, $row) {
        $row = array_count_values($row);
        $acc['#'] += $row['#'] ?? 0;
        $acc['|'] += $row['|'] ?? 0;
        $acc['.'] += $row['.'] ?? 0;
        return $acc;
    }, ['#' => 0, '|' => 0, '.' => 0]);
}

$map = $input;
for($i = 0 ; $i < 10 ; $i++ ) {
    $map = run_map($map);
}

$count = count_map($map);
echo $count['#'] * $count['|'];
