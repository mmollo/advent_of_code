<?php
$input = [];
while ($line = rtrim(fgets(STDIN))) {
    $input[] = $line;
}

class Node
{
    public $name;
    public $children = [];
    public $parents = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function add(Node $node)
    {
        $this->children[$node->name] = $node;
        $node->parents[$this->name] = $this;
    }    
}

class NodeList
{
    public $nodes = [];

    public function get($name) {
        if(!isset($this->nodes[$name])) {
            $this->nodes[$name] = new Node($name);
        }

        return $this->nodes[$name];
    }
}

function parse($str) {
    preg_match('/Step ([A-Z]) must be finished before step ([A-Z]) can begin/', $str, $matches);
    return [$matches[1], $matches[2]];
}


function process(Node $node) {
    ksort($node->children);
    if(count($node->parents) > 1) {
        return '';
    }

    $out = $node->name;

    foreach($node->children as $child) {
        $out .= process($child);
        unset($child->parents[$node->name]);
    }

    return $out;
}

// Create the tree
$nodeList = new NodeList();
foreach($input as $str) {
    list($pname, $cname) = parse($str);
    $nodeList->get($pname)->add($nodeList->get($cname));
}

// Find the roots
$root = new Node('root');
foreach($nodeList->nodes as $node) {
    if(0 === count($node->parents)) {
        $root->add($node);
    }
}
ksort($root->children);

// Read the tree
echo process($root); // HEGMPOAWBFCDITVXYZRKUQNSLJ
