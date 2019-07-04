<?php


use Imagine\Gd\Imagine;
use Imagine\Image\Box;

require "bootstrap.php";


$imagine = new Imagine();
$img = $imagine->open("uploads/20181102_185322.jpg");
$img->resize(new Box(100, 100));
$img->save("uploads/20181102_185322_small.jpg");

