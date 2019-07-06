<?php

use Imagine\Gmagick\Image;
use Imagine\Image\Box;

$file = 'uploads/z.jpg';
$imagine = new Image();
$img = $imagine->open("$file");
$box = new Box(100, 100);
$img->resize($box);
$img->save("$file");




