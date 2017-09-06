<?php

use MRB\QuadTree\AABB;
use MRB\QuadTree\QTObj;
use MRB\QuadTree\QTNode;

srand(time());


require "./vendor/autoload.php";


$limits = new AABB(0, 0, 50001, 50001);
$root = new QTNode($limits);

$obj = new QTObj(new AABB(10, 10, 20, 20));
$root->addObject($obj);

$obj = new QTObj(new AABB(5, 5, 15, 15));
$root->addObject($obj);

$obj = new QTObj(new AABB(300, 300, 400, 400));
$root->addObject($obj);

$obj = new QTObj(new AABB(10, 300, 30, 400));
$root->addObject($obj);

//print_r($root);

$objs = [];
for ($i = 0; $i < 20000; $i++) {
    $x = rand(0, 50000);
    $y = rand(0, 50000);
    $width = 100;
    $height= 100;
    $obj = new QTObj(new AABB($x, $y, $x+$width, $y+$height));
    $objs[] = $obj;
}

$start = microtime(true);
for ($i = 0; $i < 2000; $i ++) {
    $root->getIntersections($objs[$i]->GetBounds());
}

$time_end = microtime(true);
$ms = round($time_end - $start, 4);
echo 1/$ms . " fps, $ms s\n";


$limits = new AABB(0, 0, 20, 20);
print_r($root->getIntersections($limits));
