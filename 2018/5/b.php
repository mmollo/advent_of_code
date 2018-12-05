<?php
$input = '';
while ($line = rtrim(fgets(STDIN))) {
    $input .= $line;
}

function react($a, $b)
{
    return 32 === abs(ord($a) - ord($b));
}

function run($input)
{
    for ($i = 1, $n = strlen($input) ; $i < $n ; $i++) {
        if (react($input[$i-1], $input[$i])) {
            $n -= 2;
            $input = (substr($input, 0, $i - 1) . substr($input, $i+1));
            if (($i -= 2) < 0) {
                $i = 0;
            }
        }
    }
    
    return strlen($input);
}

$min = +INF;
foreach (range('a', 'z') as $unit) {
    $len = run(str_replace([$unit, strtoupper($unit)], ['', ''], $input));
    if ($len < $min) {
        $min = $len;
    }
}

echo $min . PHP_EOL;
