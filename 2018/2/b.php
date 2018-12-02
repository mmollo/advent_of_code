<?php
$input = [];
while($line = rtrim(fgets(STDIN))) {
    $input[] = $line;
}

for($i = 0 ; $i < count($input); $i++) {
    for($j = $i + 1 ; $j < count($input) ; $j++) {
        if(1 === levenshtein($input[$i], $input[$j])) {
            $first = $input[$i];
            $second = $input[$j];
            break 2;
        }
    }
}

$output = '';

for($i = 0 ; $i < strlen($first); $i++) {
    if($first[$i] === $second[$i]) {
        $output .= $first[$i];
    }
}

echo $output;

