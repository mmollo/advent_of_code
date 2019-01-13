<?php
$input = [];
while($line = rtrim(fgets(STDIN))) {
    foreach(str_split($line) as $c => $l)
    $input[$c][] = $l;
}


$message = array_map(function($col) {
    $values = array_count_values($col);
    arsort($values);
    
    $keys = array_keys($values);
    return array_shift($keys);
}, $input);

echo implode('', $message);