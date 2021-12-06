<?php

function evolve(array $input, int $days) : int {
    for($i = 0 ; $i < $days ; $i++) {

        $output = [];
        foreach($input as $fish) {
            if(0 == $fish) {
                $output[] = 6;
                $output[] = 8;
            } else {
                $fish--;
                $output[] = $fish;
            }
        }
        $input = $output;
    }

    return count($input);
}

function evolve_fast(array $input, int $days) : int {
        $pre = array_fill(0, 9, 0);
        foreach($input as $v) $pre[$v]++;
        $input = $pre;

        for($d = 0 ; $d < $days ; $d++) {
            $output = array_fill(0, 9, 0);
            foreach($input as $i => $n) {
                if(0 == $i) $output[8] = $output[6] = $n;
                else $output[$i-1] += $n;
            }
            $input = $output;
        }

        return array_sum($input);
}

function a(array $input) : int {
    return evolve_fast($input, 80);
}

function b(array $input) : int {
    return evolve_fast($input, 256);
}

$input = explode(',', rtrim(file_get_contents('./input')));

echo a($input) . PHP_EOL;
echo b($input) . PHP_EOL;
