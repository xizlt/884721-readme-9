<?php
require 'bootstrap.php';
require_once 'functions/validators/post/video.php';
$link = "https://www.youtube.com/watch?v=acIU7yxzJ70&list=RDMMacIU7yxzJ7";
//$res = check_youtube_url($link);
$res2 = extract_youtube_id($link);
$res3 = embed_youtube_video($link);
var_dump($res2);

