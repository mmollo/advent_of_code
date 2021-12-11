<?php

function adj($input, $x, $y) {
    $adj = [];
    for($i = $x -1 ; $i <= $x + 1 ; $i++) {
        for($j = $y - 1 ; $j <= $y + 1 ; $j++) {
            if($i == $x and $j == $y) continue;
            if(!isset($input["$i:$j"])) continue;
            $adj[] = [$i, $j];
        }
    }

    return $adj;
}

function step($input) {
    $flash = [];
    foreach($input as $p => &$v) {
        if(++$v == 10) $flash[] = $p;
    }

    $n = 0;
    while(count($flash)) {
        $n++;
        [$x, $y] = explode(':', array_pop($flash));

        foreach(adj($input, $x, $y) as [$x, $y]) {
            if(++$input["$x:$y"] == 10) $flash[] = "$x:$y";
        }
    }

    foreach($input as &$v) {
        if($v > 9) $v = 0;
    }


    return [$input, $n];
}

function a($input) {
    $c = 0;
    for($i = 0 ; $i < 100 ; $i++) {
        [$input, $n] = step($input);
        $c += $n;
    }

    return $c;
}

function b($input) {
    $i = 0;
    while(++$i) {
        [$input, $n] = step($input);
        foreach($input as $v) if($v) continue 2;
        break;
    }

    return $i;
}


$_input = explode("\n", rtrim(file_get_contents('./input')));
$_input = array_map('str_split', $_input);
$input = [];
foreach($_input as $x => $r) {
    foreach($r as $y => $v) {
        $input["$x:$y"] = $v;
    }
}

echo a($input) . PHP_EOL;
echo b($input) . PHP_EOL;
