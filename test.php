<?php
$w = file_get_contents('https://pbs.twimg.com/profile_images/378800000710852544/d8832a4e3301975477be73152ca29920_400x400.jpeg');

file_put_contents('uploads/gagarin.jpg', $w);