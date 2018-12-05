<?php
$input = '';
while ($line = rtrim(fgets(STDIN))) {
    $input .= $line;
}

function react($a, $b)
{
    return 32 === abs(ord($a) - ord($b));
}

for ($i = 1, $n = strlen($input) ; $i < $n ; $i++) {
    if (react($input[$i-1], $input[$i])) {
        $n -= 2;
        $input = (substr($input, 0, $i - 1) . substr($input, $i+1));
        if (($i -= 2) < 0) {
            $i = 0;
        }
    }
}

echo strlen($input);
