<?php
function adj($input, $i, $j) {
    return @array_filter([
        [$i-1, $j, $input[$i-1][$j]],
        [$i+1, $j, $input[$i+1][$j]],
        [$i, $j-1, $input[$i][$j-1]],
        [$i, $j+1, $input[$i][$j+1]],
    ], fn($x) => !is_null($x[2]));
}

function basin($input, $i, $j, $done = []) {
    $V = $input[$i][$j];
    $adj = adj($input, $i, $j);
    $l = 0;
    $done[] = "$i:$j";
    foreach($adj as [$i, $j, $v])  {
        if(in_array("$i:$j", $done)) continue;
        if($V >= $v || $v == 9) continue;
        $done[] = "$i:$j";
        [$_l, $_d] = basin($input, $i, $j, $done);
        $l = $l + $_l + 1;
        $done += $_d;
    }

    return [$l, $done];
}

function low_points($input) {
    $points = [];
    foreach($input as $i => $row) {
        foreach($row as $j => $v) {
            if(min(array_map(fn($x) => $x[2], adj($input, $i, $j))) > $v) $points[] = [$i,$j];
        }
    }

    return $points;
}
function a($input) {
    return array_reduce(low_points($input), fn($a, $x) =>  $a + 1 + $input[$x[0]][$x[1]], 0);
}

function b($input) {
    $points = low_points($input);
    foreach($points as [$i,$j]) $basins[] = basin($input, $i, $j)[0] + 1;
    rsort($basins);

    return array_reduce(array_slice($basins, 0, 3), fn($a, $x) => $a*$x, 1);
}

$input = explode("\n", rtrim(file_get_contents('./input')));
$input = array_map(fn($x) => str_split($x), $input);

echo a($input) . PHP_EOL;
echo b($input) . PHP_EOL;
