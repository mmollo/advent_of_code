<?php
function fold(array $dots, string $d, int $a) : array {
    $o = [];
    foreach($dots as [$x, $y]) {
        if(${$d} > $a) ${$d} = 2*$a - ${$d};
        if(in_array([$x, $y], $o)) continue;
        $o[] = [$x, $y];
    }

    return $o;
}

function a($dots, $commands) {

    [$d, $a] = $commands[0];
    $dots = fold($dots, $d, $a);

    return count($dots);
}

function b($dots, $commands) {
    foreach($commands as [$d, $a]) {
        $dots = fold($dots, $d, $a);
    }

    $xs = array_map(fn($x) => $x[0], $dots);
    $ys = array_map(fn($x) => $x[1], $dots);
    for($i = min($ys) ; $i <= max($ys) ; $i++) {
        for($j = min($xs) ; $j <= max($xs) ; $j++) {
            if(in_array([$j,$i], $dots)) echo '#';
            else echo ' ';
        }
        echo PHP_EOL;
    }

}

$input = rtrim(file_get_contents('./input'));
[$dots, $commands] = explode("\n\n", $input);
$dots = array_map(fn($dot) => explode(',', $dot), explode("\n", $dots));
$commands = explode("\n", $commands);
$commands = array_map(fn($command) => explode('=', str_replace('fold along ', '', $command)), $commands);

echo a($dots, $commands) . PHP_EOL;
echo b($dots, $commands) . PHP_EOL;
