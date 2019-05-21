<?php
require 'bootstrap.php';
require_once 'functions/validators/post/video.php';
$link = "https://www.youtube.com/watch?v=acIU7yxzJ70&list=RDMMacIU7yxzJ7";
//$res = check_youtube_url($link);


$data = $_SERVER['REQUEST_URI'];
if(preg_match("'test.php'", $data)) {
    print 'ok';
}else{
    print 'no';
}
var_dump($data);

