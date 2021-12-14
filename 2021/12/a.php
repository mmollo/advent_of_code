<?php

class Node
{
    public static $instances = [];

    public $name;
    public $links = [];
    public function __construct($name)
    {
        $this->name = $name;
    }
    public static function get($name) {
        return (self::$instances[$name] ??= new Node($name));
    }

    public function link($node) {
        if(in_array($node->name, $this->links)) return;
        $this->links[] = $node;
    }
    public function is_small() {
        return strtolower($this->name) === $this->name;
    }
}

function max_small($current) {
    $current = array_filter($current, fn($node) => $node->is_small());
    $current = array_map(fn($node) => $node->name, $current);
    return max(array_count_values($current));
}

function explore($node, $max = 1, $current = []) {
    $pathes = [];
    $current[] = $node;
    foreach($node->links as $link) {
        if('start' === $link->name) continue;
        if('end' === $link->name) {
            $pathes[] = array_merge($current, [$link]);
            continue;
        }

        if(in_array($link, $current) && $link->is_small() && max_small($current) === $max) continue;
        $pathes = array_merge($pathes, explore($link, $max, $current));
    }
    return $pathes;
}


function a() {
    $pathes = explore(Node::get('start'));
    return count($pathes);
}

function b() {
    $pathes = explore(Node::get('start'), 2);
    return count($pathes);
}

$input = explode("\n", rtrim(file_get_contents('./input')));
foreach($input as $line) {
    [$f,$t] = explode('-', $line);
    Node::get($f)->link(Node::get($t));
    Node::get($t)->link(Node::get($f));
}

echo a() . PHP_EOL;
echo b() . PHP_EOL;
