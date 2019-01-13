<?php

function decrypt(string $name, int $id) {
    $rot = $id % 26;
    $room = "";
    
    for($i = 0, $n = strlen($name) ; $i < $n ; $i++) {
        $l = $name[$i];
        
        if($l === "-") {
            $l = " ";
        } else {
            $l = rot($l, $rot);
            
        }
        $room .= $l;
        
        
    }
    return $room;
}

function rot(string $letter, int $rot) {
    $letter = ord($letter) + $rot;
    if($letter > 122) $letter -= 26;

    return chr($letter);
}

while($line = rtrim(fgets(STDIN))) {
    preg_match("/([a-z-]+)-([\d]+)\[([a-z]+)\]/", $line, $matches);
    list($_dummy, $name, $id, $checksum) = $matches;
    $id = (int)$id;
    $letters = array_count_values(str_split(str_replace('-', '', $name)));
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
    if($check != $checksum) {
        continue;
    } 

    $room = decrypt($name, $id);
    if(false !== strpos($room, "northpole")) {
        echo $id;
        exit;
    }    
}