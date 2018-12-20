<?php
require './VM.php';

$input = file_get_contents("php://stdin");
list($input, $script) = explode("\n\n\n", $input);


$examples = [];
foreach(explode("\n\n", $input) as $i => $test) {

    list($in, $op, $out) = explode("\n", $test);
    preg_match('/Before: +\[([\d, ]+)\]/', $in, $matches);
    $in = array_map('intval', explode(', ', $matches[1]));

    $op = array_map('intval', explode(' ', $op));
    $args = array_slice($op, 1);
    $op = $op[0];
        
    preg_match('/After: +\[([\d, ]+)\]/', $out, $matches);
    $out = array_map('intval', explode(', ', $matches[1]));
    
    $examples[] = [$in, $op, $args, $out];
}

$found = [];
$opcodes = array_flip(VM::$opcodes);
while(count($found) < 16) {   
    foreach($examples as $i => $example) {
        list($in, $op, $args, $out) = $example;
        if(isset($found[$op])) {
            continue;
        }

        $valid_op = [];
        $vm = new VM();
        foreach($opcodes as $opcode => $n) {
            $vm->setRegisters($in);
            call_user_func_array([$vm, $opcode], $args);
            $registers = $vm->getRegisters();

            if( $registers == $out ) {
                $valid_op[] = $opcode;
            }
        }
        
        if(1 === count($valid_op)) {
            $opcode = $valid_op[0];           
            $found[$op] = $opcode;
            unset($opcodes[$opcode]);
        }
        
    }
}

$opcodes = $found;

$vm = new VM();

foreach(explode("\n", $script) as $line) {
    if(!strlen($line)) {
        continue;
    }
    
    list($op, $a, $b, $c) = explode(' ', rtrim($line));
    $opcode = $opcodes[$op];

    call_user_func_array([$vm, $opcode], [$a,$b,$c]);}

print_r($vm->getRegisters()[0]);
