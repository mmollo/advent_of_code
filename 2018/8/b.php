<?php
$input = explode(' ', rtrim(fgets(STDIN)));

function node_value(&$input) {
    $nb_children = (int)array_shift($input);
    $nb_metadata = (int)array_shift($input);

    $children = [];

    for($i = 0 ; $i < $nb_children ; $i++) {
        $children[] = node_value($input);
    }

    $metadata = [];
    for($i = 0 ; $i < $nb_metadata ; $i++) {
        $metadata[] = (int)array_shift($input);
    }

    $value = 0;
    if(0 == $nb_children) {
        $value += array_sum($metadata);
    } else {
        foreach($metadata as $i) {       
            $value += $children[$i-1] ?? 0;            
        }
    }

    return $value;
}

echo node_value($input);