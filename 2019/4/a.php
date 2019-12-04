<?php

function neverDecrease(string $digits) : bool
{
    for ($i = 1 ; $i < strlen($digits) ; $i++) {
        if ($digits[$i] < $digits[$i-1]) {
            return false;
        }
    }
    return true;
}

function hasAdjacentDigits(string $digits)
{
    for ($i = 1 ; $i < strlen($digits) ; $i++) {
        if ($digits[$i] === $digits[$i-1]) {
            return true;
        }
    }
    return false;
}

function hasOnlyTwoAdjacentDigits(string $digits)
{
    return in_array(2, array_count_values(str_split($digits)));
}

list($from, $to) = explode('-', rtrim(file_get_contents(__DIR__ . '/input')));

$part1 = 0;
$part2 = 0;
for ($i = $from ; $i <= $to ; $i++) {
    if (!neverDecrease((string)$i)) {
        continue;
    }
    if (!hasAdjacentDigits((string)$i)) {
        continue;
    }
    $part1++;
    if (!hasOnlyTwoAdjacentDigits((string)$i)) {
        continue;
    }
    $part2++;
}

echo "Part 1 : $part1" . PHP_EOL;
echo "Part 2 : $part2" . PHP_EOL;
