<?php
function analyze($line, $tokens) {

    $s = [];
    foreach($line as $t) {
        if(array_key_exists($t, $tokens)) {
            $s[] = $t;
            continue;
        }
        if($tokens[array_pop($s)] != $t) return ['invalid', $t];
    }
    if(!count($s)) return ['valid', null];
    return ['incomplete', $s];
}

function a($input, $tokens) {
    $points = [')' => 3, ']' => 57, '}' => 1197, '>' => 25137];

    $score = 0;
    foreach($input as $l) {
        [$status, $data] = analyze($l, $tokens);
        if('invalid' === $status) $score += $points[$data];
    }
    return $score;
}

function b($input, $tokens) {
    $points = [')' => 1, ']' => 2, '}' => 3, '>' => 4];

    $scores = [];
    foreach($input as $l) {
        $score = 0;
        [$status, $data] = analyze($l, $tokens);
        if('incomplete' != $status) continue;
        foreach(array_reverse($data) as $t) {
            $score = $score * 5 + $points[$tokens[$t]];
        }
        $scores[] = $score;
    }
    sort($scores);

    return $scores[(count($scores) - 1) / 2];
}

$tokens = ['(' => ')', '[' => ']', '{' => '}', '<' => '>'];

$input = explode("\n", rtrim(file_get_contents('./input')));
$input = array_map(fn($x) => str_split($x), $input);

echo a($input, $tokens) . PHP_EOL;
echo b($input, $tokens) . PHP_EOL;
