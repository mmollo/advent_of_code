<?php

class Bot
{
    public static $counter = 0;

    public $id;
    public $x,$y,$z,$r;
    public function __construct(int $x = 0, int $y = 0, int $z = 0, int $r = 0) {
        $this->id = self::$counter++;
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
        $this->r = $r;
    }
}

$max_bot = new Bot();
$input = [];
while($line = rtrim(fgets(STDIN))) {
    $bot = parse_bot($line);
    if($bot->r > $max_bot->r) {
        $max_bot = $bot;
    }
    $input[$bot->id] = $bot;
    
}

function parse_bot($str) {
    preg_match('/pos=<([\d-]+),([\d-]+),([\d-]+)>, r=([\d]+)/', $str, $matches);

    return new Bot(
        (int)$matches[1],
        (int)$matches[2],
        (int)$matches[3],
        (int)$matches[4]
    );
}

function distance(Bot $a, Bot $b) {
    return abs($a->x - $b->x)
    + abs($a->y - $b->y) +
    + abs($a->z - $b->z);
}

foreach($input as &$bot) {
    $bot = distance($bot, $max_bot) <= $max_bot->r ? 1 : 0;
}

echo array_sum($input);