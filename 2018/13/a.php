<?php

class Symbol
{
    const CART_NORTH = '^';
    const CART_EAST = '>';
    const CART_SOUTH = 'v';
    const CART_WEST = '<';
    
    const NODE_VERTICAL = '|';
    const NODE_HORIZONTAL = '-';
    const NODE_INTERSECTION = '+';
    const NODE_NE = '/';
    const NODE_NW = '\\';
    
    public static function isCart($symbol)
    {
        return in_array($symbol, [
            self::CART_NORTH,
            self::CART_EAST,
            self::CART_SOUTH,
            self::CART_WEST
        ]);
    }
    
    public static function cartToNode($symbol)
    {
        if(self::CART_EAST === $symbol ||self::CART_WEST === $symbol) {
            return self::NODE_HORIZONTAL;
        }
        
        if(self::CART_NORTH === $symbol || self::CART_SOUTH === $symbol) {
            return self::NODE_VERTICAL;
        }
    }
}

class Direction
{
    const NORTH = 'north';
    const EAST = 'east';
    const SOUTH = 'south';
    const WEST = 'west';
    
    private static $directions = [
        'north', 'east', 'south', 'west'
    ];

    public static function cart_direction($symbol)
    {
        if(Symbol::CART_EAST === $symbol) return self::EAST;
        if(Symbol::CART_WEST === $symbol) return self::WEST;
        if(Symbol::CART_NORTH === $symbol) return self::NORTH;
        if(Symbol::CART_SOUTH === $symbol) return self::SOUTH;
    }
    
    public static function opposite($direction)
    {
        if(self::NORTH === $direction) return self::SOUTH;
        if(self::SOUTH === $direction) return self::NORTH;
        if(self::WEST === $direction) return self::EAST;
        if(self::EAST === $direction) return self::WEST;
    }
    
    public function turn($direction, $amount) {
        $i = array_search($direction, self::$directions);
        $i += $amount - 1;
        if($i < 0) $i += 4;
        elseif($i > 3) {
            $i -= 4;
        }
        
        return self::$directions[$i];
    }
}
abstract class Node
{
    public $x,$y;
    public $symbol;
    public $cart;

    abstract public function getLinkCoordinates();
    abstract public function getLink($direction);
    
    public function __construct($x,$y)
    {
        $this->x = $x;
        $this->y = $y;
    }
    
    public function hasCart()
    {
        return $this->cart !== null;
    }
    
    public function deleteCart()
    {
        $this->cart = null;
    }
    
    public function setCart(Cart $cart)
    {
        if($this->hasCart()) {
            var_dump($this->x, $this->y);
            die();
        }
        $this->cart = $cart;
    }
    
    
    public function link($direction, Node $node)
    {
        $this->$direction = $node;
    }
    
    public function __toString()
    {
        if($this->hasCart()) {
            return $this->cart->__toString();
        }
        return $this->symbol;
    }
}

class HorizontalNode extends Node
{
    public $symbol = Symbol::NODE_HORIZONTAL;

    public function getLinkCoordinates()
    {
        return [
            Direction::WEST => [$this->x - 1, $this->y],
            Direction::EAST => [$this->x + 1, $this->y],
        ];
    }
    
    public function getLink($direction)
    {
        if(Direction::EAST === $direction) return $this->east;
        if(Direction::WEST === $direction) return $this->west;
    }
}

class VerticalNode extends Node
{
    public $symbol = Symbol::NODE_VERTICAL;

    public function getLinkCoordinates()
    {
        return [
            Direction::SOUTH => [$this->x, $this->y + 1],
            Direction::NORTH => [$this->x, $this->y - 1],
        ];
    }

    public function getLink($direction)
    {
        if(Direction::NORTH === $direction) return $this->north;
        if(Direction::SOUTH === $direction) return $this->south;
    }    
}

class NENode extends Node
{
    public $symbol = Symbol::NODE_NE;

    public function getLinkCoordinates()
    {
        return [
            Direction::WEST => [$this->x - 1, $this->y],
            Direction::EAST => [$this->x + 1, $this->y],
            Direction::SOUTH => [$this->x, $this->y + 1],
            Direction::NORTH => [$this->x, $this->y - 1],
        ];
    }

    public function getLink($direction)
    {
        if(Direction::NORTH === $direction) return $this->north;
        if(Direction::EAST === $direction) return $this->east;
        if(Direction::SOUTH === $direction) return $this->south;
        if(Direction::WEST === $direction) return $this->west;
    }

    public function setCart(Cart $cart)
    {
        if(Direction::NORTH === $cart->direction) $cart->direction = Direction::EAST;
        elseif(Direction::EAST === $cart->direction) $cart->direction = Direction::NORTH;
        elseif(Direction::SOUTH === $cart->direction) $cart->direction = Direction::WEST;
        elseif(Direction::WEST === $cart->direction) $cart->direction = Direction::SOUTH;
        parent::setCart($cart);
    }    
    
}

class NWNode extends Node
{
    public $symbol = Symbol::NODE_NW;

    public function getLinkCoordinates()
    {
        return [
            Direction::WEST => [$this->x - 1, $this->y],
            Direction::EAST => [$this->x + 1, $this->y],
            Direction::SOUTH => [$this->x, $this->y + 1],
            Direction::NORTH => [$this->x, $this->y - 1],
        ];
    }

    public function getLink($direction)
    {
        if(Direction::NORTH === $direction) return $this->north;
        if(Direction::EAST === $direction) return $this->east;
        if(Direction::SOUTH === $direction) return $this->south;
        if(Direction::WEST === $direction) return $this->west;
    }
    
    public function setCart(Cart $cart)
    {
        if(Direction::NORTH === $cart->direction) $cart->direction = Direction::WEST;
        elseif(Direction::EAST === $cart->direction) $cart->direction = Direction::SOUTH;
        elseif(Direction::SOUTH === $cart->direction) $cart->direction = Direction::EAST;
        elseif(Direction::WEST === $cart->direction) $cart->direction = Direction::NORTH;
        parent::setCart($cart);
    }
    
}

class IntersectionNode extends Node
{
    public $symbol = Symbol::NODE_INTERSECTION;

    public function getLinkCoordinates()
    {
        return [
            Direction::WEST => [$this->x - 1, $this->y],
            Direction::EAST => [$this->x + 1, $this->y],
            Direction::SOUTH => [$this->x, $this->y + 1],
            Direction::NORTH => [$this->x, $this->y - 1],
        ];
    }

    public function getLink($direction)
    {
        if(Direction::NORTH === $direction) return $this->north;
        if(Direction::EAST === $direction) return $this->east;
        if(Direction::SOUTH === $direction) return $this->south;
        if(Direction::WEST === $direction) return $this->west;
    }
    
    public function setCart(Cart $cart)
    {
        echo sprintf("Direction %s, route is %d, turn to ...", $cart->direction, $cart->route);
        $cart->direction = Direction::turn($cart->direction, $cart->route);
        
        if(++$cart->route > 2) {
            $cart->route = 0;
        } 
        echo sprintf("%s, route is %d\n", $cart->direction, $cart->route);
        parent::setCart($cart);
    }
    
}


class NodeBuilder
{
    public static function build($symbol, $x, $y)
    {
        switch($symbol)
        {
            case Symbol::NODE_HORIZONTAL:
            case Symbol::CART_EAST:
            case Symbol::CART_WEST:
                return new HorizontalNode($x, $y);
                break;
            case Symbol::NODE_VERTICAL:
                case Symbol::CART_NORTH:
                case Symbol::CART_SOUTH:            
                return new VerticalNode($x, $y);
                break;
            case Symbol::NODE_NE:
                return new NENode($x, $y);            
                break;
            case Symbol::NODE_NW:
                return new NWNode($x, $y);            
                break;
            case Symbol::NODE_INTERSECTION:
                return new IntersectionNode($x, $y);            
                break;
            default:
                throw new Exception(":(");
        }
    }
}

class Cart
{
    public $x, $y, $direction;
    public $route;

    public function __construct($x, $y, $direction) {
        $this->x = $x;
        $this->y = $y;
        $this->direction = $direction;
        
        $this->route = 0;
    }
    
    public function move()
    {
        global $map;
        $node = $map[$this->y][$this->x];
        
        //~ echo sprintf("Cart at %d,%d %s\n", $this->x, $this->y, $this->direction);
        $direction = $this->direction;
        if(!$target = $node->getLink($direction)) {
            throw new Exception("ALERT§");
        }

        if(Direction::EAST === $direction) {
            $this->x++;
        }
        if(Direction::WEST === $direction) {
            $this->x--;
        }
        if(Direction::NORTH === $direction) {
            $this->y--;
        }
        if(Direction::SOUTH === $direction) {
            $this->y++;
        }
        

        //~ echo sprintf("Moving to %d,%d %s\n", $target->x,$target->y, $target->symbol);
        $node->deleteCart();
        $target->setCart($this);
        //~ echo sprintf("Direction %s\n", $this->direction);
        

    }
    
    public function __toString()
    {

        if(Direction::NORTH === $this->direction) $symbol = Symbol::CART_NORTH;
        if(Direction::EAST === $this->direction) $symbol = Symbol::CART_EAST;
        if(Direction::SOUTH === $this->direction) $symbol = Symbol::CART_SOUTH;
        if(Direction::WEST === $this->direction) $symbol = Symbol::CART_WEST;
        
        return "\033[0;31m" . $symbol . "\033[0m";
    }
    
}

$carts = [];
$map = [];

$y = 0;
while($line = rtrim(fgets(STDIN))) {
    $map[$y] = array_fill(0, strlen($line), ' ');
    $line = str_split($line);
    foreach($line as $x => $symbol) {
        if(' ' === $symbol) continue;
        $node = NodeBuilder::build($symbol, $x, $y);

        if(Symbol::isCart($symbol)) {
            $cart = new Cart($x, $y, Direction::cart_direction($symbol));
            $carts[] = $cart;
            $symbol = Symbol::cartToNode($symbol);
            $node->cart = $cart;
        }
        
        $map[$y][$x] = $node;
        foreach($node->getLinkCoordinates() as $direction => $linkCoordinates) {
            list($nx,$ny) = $linkCoordinates;

            if(!array_key_exists($ny, $map)) {
                continue;
            }
            if(!array_key_exists($nx, $map[$ny])) {
                continue;
            }

            if (!($map[$ny][$nx] instanceof Node)) {
                continue;
            }
            
            $link = $map[$ny][$nx];
            $node->link($direction, $link);
            $link->link(Direction::opposite($direction), $node);
        }
        
    }
    $y++;
}


function display(array $map)
{
    foreach($map as $y => $row) {
        foreach($row as $x => $d) {
            echo $d;
        }
        echo PHP_EOL;
    }
}

function cls() {
    echo "\033c";
}





//Game is ready, let's move!
while(1) {
    //cls();
    //display($map);
    foreach($carts as &$cart) {
        $cart->move();
    }
    //$carts[1]->move();
    
    sleep(0);
}

//var_dump($map);

