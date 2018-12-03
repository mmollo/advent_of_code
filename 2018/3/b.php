<?php
$input = [];
while ($line = rtrim(fgets(STDIN))) {
    $input[] = $line;
}

$fabric = $bad = $good = [];

foreach ($input as $claim) {
    preg_match('/^#([0-9]+) @ ([0-9]+),([0-9]+): ([0-9]+)x([0-9]+)/', $claim, $matches);
    list($dummy, $id, $x, $y, $w, $h) = $matches;
    for ($i = $x ; $i < $x + $w ; $i++) {
        for ($j = $y ; $j < $y + $h ; $j++) {
            $key = $i . '_' . $j;

            if (!isset($fabric[$key])) {
                $fabric[$key] = $id;
                if (!isset($bad[$id])) {
                    $good[$id] = true;
                }
            } else {
                $old_id = $fabric[$key];
                $bad[$id] = $bad[$old_id] = true;
                unset($good[$id], $good[$old_id]);
            }
        }
    }
}

echo array_keys($good)[0];
