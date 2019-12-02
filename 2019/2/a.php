<?php

$input = explode(',', rtrim(file_get_contents('./input')));

function A(array $input, int $noun = 12, int $verb = 2) : int
{
    $input[1] = $noun;
    $input[2] = $verb;

    $pos = 0;
    while (true) {
        switch ($input[$pos]) {
            case '1':
                $input[$input[$pos+3]] = $input[$input[$pos+1]] + $input[$input[$pos+2]];
                $pos += 4;
                break;
            case '2':
                $input[$input[$pos+3]] = $input[$input[$pos+1]] * $input[$input[$pos+2]];
                $pos += 4;
                break;
            case '99':
                return $input[0];
            default:
                throw new Exception("Invalid opcode");
        }
    }
}

function B(array $input) : int
{
    $target = 19690720;
    for ($noun = 0 ; $noun < 100 ; $noun++) {
        for ($verb = 0 ; $verb < 100 ; $verb++) {
            $result = A($input, $noun, $verb);
            if ($result === $target) {
                return 100 * $noun + $verb;
            }
        }
    }
}

$result = A($input);
echo "Part 1 : $result" . PHP_EOL;

$result = B($input);
echo "Part 2 : $result" . PHP_EOL;
