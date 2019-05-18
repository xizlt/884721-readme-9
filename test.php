<?php
require 'bootstrap.php';
$p = "https://pbs.twimg.com/profile_images/378800000710852544/d8832a4e3301975477be73152ca29920_400x400.jpeg";
$w = file_get_contents($p);
file_put_contents('uploads/' .basename($p) , $w);
$post_data ['img']= 'uploads/' .basename($p);

var_dump($post_data);