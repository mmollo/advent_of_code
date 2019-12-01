<?php
function mass2fuel(int $mass) : int {
	return floor($mass / 3) - 2;
}

function total_fuel(int $fuel) : int {
	$total = 0;
	while($fuel > 0) {
		$total += $fuel = max(0, mass2fuel($fuel));
	}
	
	return $total;
}

$input = file('./input', FILE_IGNORE_NEW_LINES);

$fuel = array_sum(array_map('mass2fuel', $input));
echo "Part 1 : $fuel" . PHP_EOL;

$fuel = array_sum(array_map(function($mass) {
	$fuel = mass2fuel($mass);
	return $fuel + total_fuel($fuel);
}, $input));
echo "Part 2 : $fuel" . PHP_EOL;
