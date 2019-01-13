<?php
$input = $argv[1] ?? "wtnhxymk";

$code = [];
$i = 0;
while(++$i) {
    $hash = md5($input . $i);
    if(substr($hash, 0, 5) !== "00000") continue;

    $pos = substr($hash, 5, 1);

    if(!is_numeric($pos)) continue;
    if($pos > 7) continue;
    if(isset($code[$pos])) continue;
    
    $char = substr($hash, 6, 1);
    $code[$pos] = $char;

    if(count($code) === 8) break;
}

ksort($code);
echo implode('', $code);