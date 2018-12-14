<?php
define('SERIAL', intval($argv[1] ?? 8868));
define('GRID_SIZE', 300);

function cell_power($x, $y) {
    $rack = $x + 10;
    $power = $rack * $y;
    $power += SERIAL;
    $power *= $rack;
    $power = floor($power / 100) % 10;
    $power -= 5;

    return $power;
}

$partials = array_fill(0, GRID_SIZE+1, array_fill(0, GRID_SIZE+1, 0));

for($y = 1 ; $y <= GRID_SIZE ; $y++) {
    for($x = 1 ; $x <= GRID_SIZE ; $x++) {

        $cells[$x][$y] = cell_power($x,$y);
        
        $partials[$x][$y] = cell_power($x, $y)
        + ($partials[$x-1][$y] ?? 0)
        + ($partials[$x][$y-1] ?? 0)
        - ($partials[$x-1][$y-1] ?? 0);
    }
}

function selector_power($x, $y, $size) {
    $x--;
    $y--;
    global $partials;
    
    return $partials[$x+$size][$y+$size]
        - $partials[$x+$size][$y]
        - $partials[$x][$y+$size]
        + $partials[$x][$y];
}

function max_power($selector_size) {
    $max_power = -INF;
    $max_cell = null;
    for($y = 1 ; $y <= GRID_SIZE - $selector_size ; $y++) {
        for($x = 1 ; $x <= GRID_SIZE - $selector_size ; $x++) {
            $selector_power = selector_power($x, $y, $selector_size);
            if($selector_power > $max_power) {
                $max_power = $selector_power;
                $max_cell = [$x, $y, $max_power];
            }
        }
    }

    return $max_cell;
}

$max_power = -INF;
$max_conf = null;
for($i = 1 ; $i <= GRID_SIZE ; $i++) {
    list($x, $y, $power) = max_power($i);
    if($power > $max_power) {
        $max_power = $power;
        $max_conf = [$x, $y, $i];
    }
}

echo implode(',', $max_conf);