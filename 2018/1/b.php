<?php
while($line = rtrim(fgets(STDIN))) {
    $var[] = (int)$line;
}

$found = false;
$freq = 0;
$past = [];
$count = 0;
while(!$found) {
    foreach($var as $v) {
        $freq += $v;
        if(array_key_exists($freq, $past)) {
            $found = true;
            break;
        }
        $past[$freq] = true;
    }
}

echo $freq;