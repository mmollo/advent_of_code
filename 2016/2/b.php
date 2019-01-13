<?php

$grid = [
    [null, null, 1, null, null],
    [null, 2, 3, 4, null],
    [5,6,7,8,9],
    [null, "A", "B", "C", null],
    [null, null, "D", null, null]
];

$code = "";
list($y, $x) = [2, 0];
foreach(file("input") as $line) {
    $line = rtrim($line);
    foreach(str_split($line) as $direction) {
        switch($direction) {
            case "U":
                $move = [$x, $y-1];
                break;
            case "D":
                $move = [$x, $y+1];
                break;
            case "R":
                $move = [$x+1, $y];
                break;
            case "L":
                $move = [$x-1, $y];
                break;
        }

        list($x2, $y2) = $move;
        if(@is_null($grid[$y2][$x2])) {
            continue;
        }
        list($x,$y) = $move;
    }
   

    $code .= $grid[$y][$x];
}

echo $code;