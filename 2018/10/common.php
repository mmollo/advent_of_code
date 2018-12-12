<?php
$input = [];
while ($line = rtrim(fgets(STDIN))) {
    $input[]= $line;
}

$lights = $vel = [];

foreach($input as $i => $line) {
    preg_match('/<(.+)>.+<(.+)>/', $line, $matches);
    list($x, $y) = explode(',', $matches[1]);
    list($h, $v) = explode(',', $matches[2]);
    $lights[$i] = array_map('intval', [$x, $y, $h, $v]);
}


function get_edges(array $lights) {
    $edges = [+INF,-INF,+INF,-INF];
    foreach($lights as $light) {
        list($x,$y,$h,$w) = $light;
        $edges = [
            $x < $edges[0] ? $x : $edges[0],
            $x > $edges[1] ? $x : $edges[1],
            $y < $edges[2] ? $y : $edges[2],
            $y > $edges[3] ? $y : $edges[3],
        ];
    }

    return $edges;
}

function move(array $lights) {
    $ret = [];
    foreach($lights as $i => $light) {
        list($x,$y,$h,$v) = $light;
        $light[0] += $h;
        $light[1] += $v;
        $ret[$i] = $light;
    }

    return $ret;
}

/**
 * This is the hard part, there are various methods to guess the better 'frame' to render.
 * Here, we use the frame where the lights are occupying the least amount of space.
 * Maybe another method could be to count the successive lights occurences by line and column.
 */
function move_to_minimal_area(array $lights) {
    $last_area = +INF;
    $t = 0;
    while(1) {
        $new_stars = move($lights);
        list($a,$b,$c,$d) = get_edges($new_stars);
        $area = abs($b-$a) * abs($d-$c);
        if($area > $last_area) {
            break;
        }
        $last_area = $area;
        $lights = $new_stars;
        $t++;
    }

    return [$t, $lights];
}

function render(array $lights, $zoom = 10 , $file = 'output.png') {
    list($a,$b,$c,$d) = get_edges($lights);

    $img_w = ($b - $a) * $zoom + ($zoom * 3);
    $img_h = ($d - $c) * $zoom + ($zoom * 3);
    
    $img = imagecreatetruecolor($img_w, $img_h);
    $color = imagecolorallocate($img, 255,255,255);
    
    
    $points = array_unique(array_map(function($light) {
        return $light[0].','.$light[1];
    }, $lights));
        
    foreach($points as $point) {
        list($x,$y) = explode(',', $point);
        
        $point_w = ($x-$a) * $zoom + $zoom;
        $point_h = ($y-$c) * $zoom + $zoom;    
        imagefilledrectangle($img, $point_w, $point_h, $point_w + $zoom, $point_h + $zoom, $color);
    }
    
    return imagepng($img, "out.png", 0);
}

