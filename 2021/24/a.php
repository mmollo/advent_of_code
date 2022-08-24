<?php

function run($commands, $stack) {
	$cpu = ['w' => 0, 'x' => 0, 'y' => 0, 'z' => 0];
	

	foreach($commands as $command) {
		//echo "\n---------\n$command\n";
		$arg = explode(' ', $command);
		$c = $arg[0];
		$a = $arg[1];
		$b = $arg[2] ?? null;
		
		if(!is_null($b)) {
			$b = is_numeric($b) ? $b : $cpu[$b];
		}
		switch($arg[0]) {
			case 'inp':
				$v = (int)array_shift($stack);
				//echo "inp $a $v";
				$cpu[$a] = $v;
				break;
			case 'add':
				//echo "add $a($cpu[$a]) $b";
				$cpu[$a] = $cpu[$a] + $b;
				break;
			case 'mod':
				//echo "mod $a($cpu[$a]) $b";
				$cpu[$a] = (int)($cpu[$a] % $b);
				break;
			case 'div':
				//echo "div $a($cpu[$a]) $b";
				$cpu[$a] = (int)floor($cpu[$a] / $b); 
				break;
			case 'mul':
				//echo "mul $a($cpu[$a]) $b";
				$cpu[$a] *= $b;
				break;
			case 'eql':
				$cpu[$a] = $cpu[$a] == $b ? 1 : 0;
				break;
				
			default:
				die("Unknow arg $arg[0]");
		}
		//echo " = $cpu[$a]\n";
		
	}
	
	return $cpu;
}

function a($input) {
	$n = (int)str_repeat(1, 14);
	while(1) {
		$stack = str_pad($n++, 14, '0', STR_PAD_LEFT);
		if(strpos($stack, '0') != false) continue;
		echo "$stack\n";

		$stack = str_split($stack);
		$cpu = run($input, $stack);
		if(!$cpu['z']) die($n);
	}
}

$input = explode("\n", rtrim(file_get_contents('./input')));
echo a($input) . PHP_EOL;
