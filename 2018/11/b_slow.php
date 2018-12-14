<?php
ini_set('memory_limit', '4000M');
define('SERIAL', intval($argv[1] ?? 8868));
define('GRID_SIZE', 300);

function cell_power($x, $y, $serial = SERIAL) {
    $rack = $x + 10;
    $power = $rack * $y;
    $power += $serial;
    $power *= $rack;
    $power = intval(substr($power, -3, 1));
    $power -= 5;

//    echo "CP $x $y : $power\n";

    return $power;
}



function cached(Callable $callable, array $arguments = []) {
    // It will only works with scalar arguments
    static $cache = [];

    $key = $callable . ':' . implode(':', $arguments);
    
    if(array_key_exists($key, $cache)) {
        return $cache[$key];
    }

    $value = call_user_func_array($callable, $arguments);
    $cache[$key] = $value;

    return $value;
}


function selector_power_classic($x, $y, $selector_size,  $serial = SERIAL) {
    $power = 0;
    for($j = 0 ; $j < $selector_size ; $j++) {
        for($i = 0 ; $i < $selector_size ; $i++) {
            $power += cell_power($i+$x, $j+$y, $serial);
            //$power += cached('cell_power', [$i+$x, $j+$y, $serial]);
        }
    }
    
    return $power;
}

function selector_power($x, $y, $selector_size, $serial = SERIAL) {
    return selector_power_recursive($x, $y, $selector_size, $serial);
    //return selector_power_classic($x, $y, $selector_size, $serial);
}

function selector_power_recursive($x, $y, $selector_size, $serial = SERIAL) {
    //echo "SP($selector_size) $x $y \n";
    $power = 0;
    for($i = 0 ; $i < $selector_size ; $i++) {
        $power += cell_power($i + $x, $y + $selector_size - 1, $serial);
    }
    for($i = 0 ; $i < $selector_size - 1; $i++) {
        $power += cell_power($x + $selector_size - 1, $i + $y, $serial);
    }

    if($selector_size) {
        $power += cached('selector_power', [$x, $y, $selector_size - 1, $serial]);
    }

    //echo "SP($selector_size) $x $y $power\n";

    return $power;
}

function max_power($selector_size, $serial = SERIAL) {
    $max_power = -INF;
    $max_cell = null;
    for($y = 0 ; $y <= GRID_SIZE - $selector_size ; $y++) {
        for($x = 0 ; $x <= GRID_SIZE - $selector_size ; $x++) {
            //$selector_power = selector_power($x, $y, $selector_size);
            $selector_power = cached('selector_power', [$x, $y, $selector_size]);
            if($selector_power > $max_power) {
                $max_power = $selector_power;
                $max_cell = [$x, $y, $max_power];
            }
        }
    }

    return $max_cell;
}

$max = -INF;
$max_conf = null;
for($i = 1 ; $i <= GRID_SIZE; $i++) {
    list($x, $y, $power) = max_power($i);
    if($power > $max) {
        $max = $power;
        $max_conf = [$x,$y,$power];
    }
    echo "S $i X $x Y $y P $power\n";
}

echo implode(',', $max_conf) . PHP_EOL;