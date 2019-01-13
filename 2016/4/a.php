<?php

$out = 0;
while($line = rtrim(fgets(STDIN))) {
    preg_match("/([a-z-]+)-([\d]+)\[([a-z]+)\]/", $line, $matches);
    list($_dummy, $name, $id, $checksum) = $matches;
    $id = (int)$id;
    $name = str_replace('-', '', $name);
    $letters = array_count_values(str_split($name));
    arsort($letters);
    
    $sorted = [];
    foreach($letters as $k => $v) {
        $sorted[] = $v * 1000 + (ord('z') - ord($k));
    }
    rsort($sorted);
    
    $sorted = array_map(function($e) {
        $k = intdiv($e, 1000);
        $v = $e % 1000;
        return [$k, chr(ord('z') - $v)];
    }, $sorted);
   
    $sorted = array_slice($sorted, 0, 5);
    
    $check = '';
    foreach($sorted as $e) {
        list($k, $v) = $e;
        $check .= $v;
    }
    if($check == $checksum) {
        $out += $id;
    }    
}

echo $out;