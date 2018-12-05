<?php
$input = [];
while ($line = rtrim(fgets(STDIN))) {
    $input[] = $line;
}

sort($input);
$guards = [];
$active_id = null;
foreach ($input as $line) {
    preg_match('/^\[[0-9-]+-([0-9]+) ([0-9]+):([0-9]+)\] ([a-zG]+) (#([0-9]+))?/', $line, $matches);
    list($dummy, $day, $hour, $min, $type) = $matches;
    $active_id = $matches[6] ?? $active_id;
    
    if (!isset($guards[$active_id])) {
        $guards[$active_id] = [
            'time' => [$hour,$min],
            'sleep_time' => 0,
            'details' => []
        ];
    }
    
    $guard = &$guards[$active_id];
        
    if ('falls' === $type) {
        $guard['time'] = [$hour,$min];
        continue;
    }
    
    if ('wakes' === $type) {
        if ($hour < $guard['time'][0]) {
            $min += 64;
        }
        $guard['sleep_time']+= $min - $guard['time'][1];
        for ($i = $guard['time'][1] ; $i < $min ; $i++) {
            $m = $i % 60;
            if (!isset($guard['details'][$m])) {
                $guard['details'][$m] = 0;
            }
            $guard['details'][$m]++;
        }
    }
}

$selected_minute = null;
$max_times = 0;
$selected_id = null;
foreach ($guards as $guard_id => $guard_data) {
    foreach ($guard_data['details'] as $minute => $times) {
        if ($times > $max_times) {
            $max_times = $times;
            $selected_minute = $minute;
            $selected_id = $guard_id;
        }
    }
}

echo $selected_minute * $selected_id;
