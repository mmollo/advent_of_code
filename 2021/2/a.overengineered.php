<?php

interface SubmarineInterface
{
    function move(int $direction, int $value);
    function where(): array;
}

abstract class Submarine implements SubmarineInterface
{
    protected $x = 0,
        $y = 0;

    public function where(): array
    {
        return [$this->x, $this->y];
    }

    public function move($direction, $value)
    {
        $this->$direction($value);

        return $this;
    }
}

class NormalSubmarine extends Submarine
{
    protected function forward($value)
    {
        $this->x += $value;
    }

    protected function up($value)
    {
        $this->y -= $value;
    }

    protected function down($value)
    {
        $this->y += $value;
    }
}

class AimingSubmarine extends Submarine
{
    private $aim = 0;

    protected function forward($value)
    {
        $this->x += $value;
        $this->y += $value * $this->aim;
    }

    protected function up($value)
    {
        $this->aim -= $value;
    }

    protected function down($value)
    {
        $this->aim += $value;
    }
}

function run(SubmarineInterface $sub, array $input): int
{
    foreach ($input as $command) {
        list($direction, $value) = $command;

        $sub->move($direction, $value);
    }

    list($x, $y) = $sub->where();
    return $x * $y;
}

function a(array $input): int
{
    $sub = new NormalSubmarine();
    return run($sub, $input);
}

function b(array $input): int
{
    $sub = new AimingSubmarine();
    return run($sub, $input);
}

$input = explode("\n", rtrim(file_get_contents('input')));
$input = array_map(function ($str) {
    return explode(" ", $str);
}, $input);


echo a($input) . PHP_EOL;
echo b($input) . PHP_EOL;
