<?php

function A(array $input) : int
{
    function orbitsum(array &$orbits, string $point, int $start = 0) : int
    {
        if (!count($orbits[$point])) {
            return $start;
        }

        $next = $start+1;
        foreach ($orbits[$point] as $parent) {
            $start += orbitsum($orbits, $parent, $next);
        }

        return $start;
    }
    
    $orbits = [];

    foreach ($input as $orbit) {
        list($to, $from) = explode(')', $orbit);
        $orbits[$to] = $orbits[$to] ?? [];
        $orbits[$from] = $orbits[$from] ?? [];
        $orbits[$to][] = $from;
    }

    return orbitsum($orbits, 'COM');
}

function B(array $input) : int
{
    $nodes = [];
    foreach ($input as $link) {
        list($to, $from) = explode(')', $link);
        $nodes[$to] = $nodes[$to] ?? [];
        $nodes[$from] = $nodes[$from] ?? [];
        $nodes[$from][] = $to;
        $nodes[$to][] = $from;
    }


    function find_path(array &$nodes, string $from, string $to, string $prev = null, int $dist = 0) : int
    {
        if (in_array($to, $nodes[$from])) {
            return $dist;
        }

        $out = [];
        foreach ($nodes[$from] as $node) {
            if ($prev === $node) {
                continue;
            }
            if ($res = find_path($nodes, $node, $to, $from, $dist+1)) {
                $out[] = $res;
            }
        }

        return !empty($out) ? min($out) : PHP_INT_MAX;
    }

    return find_path($nodes, 'YOU', 'SAN') - 1;
}

$input = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES);

$result = A($input);
echo "Part 1 : $result" . PHP_EOL;

$result = B($input);
echo "Part 2 : $result" . PHP_EOL;
