<?php
$input = [];
while($line = rtrim(fgets(STDIN))) $input[] = $line;

function tls(string $str) {
    foreach(get_hypernet($str) as $sub)
        if(abba($sub)) return false;

    return abba($str);
}

function ssl(string $str) {
    $subs = get_hypernet($str);
    
    $babs = [];
    foreach($subs as $sub) {
        $babs = array_merge($babs, babs($sub));
    }

    if(empty($babs)) return false;

    $str = remove_hypernet($str);
    
    $abas = array_map(function($e) {
        return bab2aba($e);
    }, babs($str));

    if(empty($abas)) return false;

    return count(array_intersect($babs, $abas)) > 0;
}

function bab2aba(string $str) {
    return $str[1] . $str[0] . $str[1];
}

function babs(string $str) {
    $out = [];
    for($i = 2, $n = strlen($str); $i < $n ; $i++) {
        $sub = substr($str, $i - 2, 3);
        if($sub[0] == $sub[2] && $sub[0] != $sub[1]) $out[] = $sub;
    }

    return $out;
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
    return preg_replace("/\[[a-z]+\]+/", "[]", $str);
}

$output = array_filter($input, "ssl");
echo count($output);