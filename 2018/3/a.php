<?php
$input = [];
while ($line = rtrim(fgets(STDIN))) {
    $input[] = $line;
}

$fabric = array_fill(0, 1000, array_fill(0, 1000, 0));
$overlap = 0;
foreach ($input as $claim) {
    preg_match('/^#[0-9]+ @ ([0-9]+),([0-9]+): ([0-9]+)x([0-9]+)/', $claim, $matches);
    list($dummy, $x, $y, $w, $h) = $matches;
    for ($i = $x ; $i < $x + $w ; $i++) {
        for ($j = $y ; $j < $y + $h ; $j++) {
            if ($fabric[$i][$j] == 2) {
                continue;
            }
            if ($fabric[$i][$j] == 1) {
                $overlap++;
            }
            $fabric[$i][$j]++;
        }
    }
}
echo $overlap;
