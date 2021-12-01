<?php
$input = array_map('intval' , explode("\n", rtrim(file_get_contents(__DIR__ . '/input'))));

function a($input) {
    $count = 0;

    for($i = 1; $i < count($input) ; $i++) {
        $current = $input[$i];
        $last = $input[$i-1];
        if($current > $last) $count++;
    }
    return $count;
}

function b($input) {
    $count = 0;

    for($i = 3; $i < count($input) ; $i++) {
        $current = array_sum(array_slice($input, $i-2, 3));
        $last = array_sum(array_slice($input, $i-3, 3));
        if($current > $last) $count++;
    }
    return $count;
}

echo a($input) . PHP_EOL;
echo b($input) . PHP_EOL;
