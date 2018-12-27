<?php
$map = array_fill(0, 1000, array_fill(0, 1000, false));

while($line = rtrim(fgets(STDIN))) {
    preg_match('/([a-z ]+) ([\d]+),([\d]+) through ([\d]+),([\d]+)/', $line, $matches);

    list($dummy, $action, $xa, $ya, $xb, $yb) = $matches;
    for($i = $xa ; $i <= $xb ; $i++) {
        for($j = $ya ; $j <= $yb ; $j++) {
            switch($action) {
                case 'turn on':
                    $map[$i][$j]++;
                    break;
                case 'turn off':
                    $map[$i][$j] = max(0, $map[$i][$j] -1);
                    break;
                case 'toggle':
                    $map[$i][$j] = 2 + $map[$i][$j];
                    break;
            }   
        }
    }
}

$count = 0;
foreach($map as $x => $col) {
    foreach($col as $y => $val) {
        $count += (int)$val;
    }
}
echo $count;
