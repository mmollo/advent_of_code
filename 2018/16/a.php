<?php
require './VM.php';

$input = file_get_contents("php://stdin");
$input = explode("\n\n\n", $input)[0];

$vm = new VM();
$total = 0;
foreach(explode("\n\n", $input) as $i => $test) {
    list($in, $op, $out) = explode("\n", $test);
    preg_match('/Before: +\[([\d, ]+)\]/', $in, $matches);
    $in = array_map('intval', explode(', ', $matches[1]));

    $op = array_map('intval', explode(' ', $op));
    $args = array_slice($op, 1);
    $op = $op[0];
        
    preg_match('/After: +\[([\d, ]+)\]/', $out, $matches);
    $out = explode(', ', $matches[1]);

    $count = 0;    
    foreach(VM::$opcodes as $opcode) {
        $vm->setRegisters($in);
        call_user_func_array([$vm, $opcode], $args);
        if( $vm->getRegisters() == $out ) {
            $count++;
        }
    }    
    if($count >= 3) $total++;
}

echo $total;
