<?php
$input = explode(' ', rtrim(fgets(STDIN)));


function metadata_sum(array &$tree, $n = 0)
{
    $nb_children = (int)array_shift($tree);
    $nb_metadata = (int)array_shift($tree);

    $metadata = 0;
    for($i = 0 ; $i < $nb_children ; $i++) {
        $metadata += metadata_sum($tree);
    }
    
    for($i = 0 ; $i < $nb_metadata ; $i++) {
        $metadata += (int)array_shift($tree);
    }

    return $metadata;
}


echo metadata_sum($input);