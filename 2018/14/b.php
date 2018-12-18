<?php

$input = rtrim(fgets(STDIN));

function resolve(string $input) {
    $recipes = "37";
    $elves = [0,1];

    while(1) {        
        $scores = array_reduce($elves, function($acc, $elf) use ($recipes) {
            return $acc + $recipes[$elf];
        }, 0);
        
        $recipes .= $scores;
        
        $elves = array_map(function($elf) use ($recipes) {
            return ($elf + 1 + $recipes[$elf]) % strlen($recipes);
        }, $elves);
       
        if(null !== strpos($scores, $input[-1])) {
                $haystack = substr($recipes, -1 * strlen($input) - 2); // Not sure if this is optimal
            if(false !== $pos = strpos($haystack, $input)) {
                $pos = strpos($recipes, $input);
                break;
            }
        }
    }
    
    return $pos;
    
}

function test($test, $a, $b) {
    if($a !== $b) {
        throw new Exception(sprintf("Test %s failed, expecting %s, got %s", $test, $a, $b));
    }
}
test('51589', 9, resolve('51589'));
test('5', 5, resolve('01245'));
test('18', 18, resolve('92510'));
test('2018', 2018, resolve('59414'));

echo resolve($input);