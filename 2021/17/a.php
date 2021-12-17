<?php

function a($input) {
    [$a, $b, $d, $c] = $input;
    $hits = [];

    for($i = 0; $i < $b+1; $i++) {
        for($j = $d-1 ; $j < -$d ; $j++) {
            $x = $y = $max_y = 0;
            $vx = $i;
            $vy = $j;
            do {
                [$x, $y, $vx, $vy] = [$x + $vx, $y + $vy, max(0, $vx - 1), $vy -1];
                $max_y = max($max_y, $y);
                $inside = $x >= $a && $x <= $b && $y <= $c && $y >= $d;
            } while($x <= $b && $y > $d && !$inside);
            if($inside) $hits["$i,$j"] = $max_y;
        }
    }


    return [max($hits), count($hits)];
}

$input = file_get_contents('./input');
preg_match_all("/([0-9-]+)/", $input, $matches);
$input = $matches[1];

print_r(a($input)) . PHP_EOL;

