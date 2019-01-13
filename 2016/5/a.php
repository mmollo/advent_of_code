<?php
$input = $argv[1] ?? "wtnhxymk";

$code = "";
$i = 0;
while(++$i) {
    $hash = md5($input . $i);
    if(substr($hash, 0, 5) !== "00000") continue;
    $code .= substr($hash, 5, 1);
    if(strlen($code) === 8) break;
}

echo $code;