<?php

require 'VM.php';

$ip = (int)rtrim(fgets(STDIN))[-1];

$program = [];
while($line = rtrim(fgets(STDIN))) {
    $program[] = $line;
}
;

$vm = new VM();
$vm
    ->bindIP($ip)
    ->load($program)
    ->run();

echo $vm->getRegisters()[0];