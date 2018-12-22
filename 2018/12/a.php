<?php
$initial_state = parse_initial_state(rtrim(fgets(STDIN)));
fgets(STDIN);

$patterns = [];
while ($line = rtrim(fgets(STDIN))) {
    $patterns[]= $line;
}


$patterns = parse_patterns($patterns);

function parse_initial_state(string $str) {
    return explode(' ', $str)[2];
}

function parse_patterns(array $patterns_str) {
    $patterns = [];
    foreach($patterns_str as $str) {
        list($pattern, $result) = explode(' => ', $str);
        $patterns[$pattern] = $result;
    }

    return $patterns;
}

function evolve(string $sample, array $patterns) {
    if(5 != strlen($sample)) die('o');
    if(!isset($patterns[$sample])) {
        return '.';
        return substr($sample, 2, 1);
    }
    return $patterns[$sample];
    return substr($sample, 0, 2) . $patterns[$sample] . substr($sample, 3);
}

function process(string $state, array $patterns) {
    $out  = '';
    $state = '...' . $state . '...';
    for($i = 2, $n = strlen($state) -2 ; $i < $n ; $i++) {
        $sample = substr($state, $i - 2, 5);
        $out .= evolve($sample, $patterns);
    }

    return $out;
}


$state = $initial_state;
$start = 0;
for($i = 0 ; $i < 20 ; $i++) {
    $start -= 1;
    $state = process($state, $patterns);
    if(substr($state, 0, 5) === '.....') {
        $state = substr($state, 5);
        $start += 5;
    }
}

$score = 0;
for($i = 0, $n = strlen($state) ; $i < $n ; $i++) {
    if('#' === $state[$i]) {
        $score += ($i + $start);
    }
}
echo $score;