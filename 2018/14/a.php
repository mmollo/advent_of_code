<?php

$input = (int)rtrim(fgets(STDIN));

function resolve($input) {
    $recipes = [3,7];

    $elf0 = 0;
    $elf1 = 1;

    while(count($recipes) < $input + 10) {
        $scores = array_map('intval', str_split($recipes[$elf0] + $recipes[$elf1]));
        $recipes = array_merge($recipes, $scores);
        $elf0 = ($elf0 + 1 + $recipes[$elf0]) % count($recipes);
        $elf1 = ($elf1 + 1 + $recipes[$elf1]) % count($recipes);
    }

    $result = implode('', array_slice($recipes, $input, 10));
    
    return $result;
}

function test($test, $a, $b) {
    if($a !== $b) {
        throw new Exception(sprintf("Test %s failed, expecting %s, got %s", $test, $a, $b));
    }
}
test('9', '5158916779', resolve(9));
test('5', '0124515891', resolve(5));
test('18', '9251071085', resolve(18));
test('2018', '5941429882', resolve(2018));

echo resolve(9);