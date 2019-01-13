<?php
$input = [];
while($line = rtrim(fgets(STDIN))) $input[] = $line;

function tls(string $str) {
    foreach(get_hypernet($str) as $sub)
        if(abba($sub)) return false;

    return abba($str);
}

function abba(string $str) {
    for($i = 3, $n = strlen($str) ; $i < $n ; $i++) {
        $sub = substr($str, $i-3, 4);    
        if(
            $sub[0] == $sub[3] &&
            $sub[1] == $sub[2] &&
            $sub[0] != $sub[1]
        ) return true;
    }

    return false;
}

function get_hypernet(string $str) {
    if(!preg_match_all("/\[([a-z]+)\]/", $str, $matches)) return [];
    return $matches[1];
    
}

function remove_hypernet(string $str) {
    return preg_replace("/\[[a-z]+\]+/", "", $str);
}

$output = array_filter($input, "tls");
echo count($output);