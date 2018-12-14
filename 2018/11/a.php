<?php
define('SERIAL', intval($argv[1] ?? 8868));
define('GRID_SIZE', 300);
define('SELECTOR_SIZE', 3);

function cell_power($x, $y, $serial = SERIAL) {
    $rack = $x + 10;
    $power = $rack * $y;
    $power += $serial;
    $power *= $rack;
    $power = intval(substr($power, -3, 1));
    $power -= 5;

    return $power;
}

function selector_power($x, $y, $selector_size = SELECTOR_SIZE, $serial = SERIAL) {
    $power = 0;
    for($j = 0 ; $j < $selector_size ; $j++) {
        for($i = 0 ; $i < $selector_size ; $i++) {
            $power += cell_power($i+$x, $j+$y, $serial);
        }
    }

    return $power;
}

$max_power = -INF;
$max_cell = null;
for($y = 0 ; $y <= GRID_SIZE - SELECTOR_SIZE ; $y++) {
    for($x = 0 ; $x <= GRID_SIZE - SELECTOR_SIZE ; $x++) {
        $selector_power = selector_power($x, $y);
        if($selector_power > $max_power) {
            $max_power = $selector_power;
            $max_cell = [$x, $y];
        }
    }
}
var_dump($max_power);
echo implode(',', $max_cell) . PHP_EOL;
