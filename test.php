<?php
require 'bootstrap.php';
$link = "http://evacademy.ru/bundles/daetheme/frontend/img/logo.png?3";
/*$w = file_get_contents($p);
file_put_contents('uploads/' .basename($p) , $w);
$post_data ['img']= 'uploads/' .basename($p);*/


/*$urlHeaders = get_headers($link, 1);
if (!strpos($urlHeaders[0], '200')) {
     $arr = 'no';
}else
{
    $arr = 'ok';
}
*/
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => $link,
    CURLOPT_HEADER => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_NOBODY => true));
$re = !strpos($curl[0], '200');
curl_close($curl);


var_dump($re);
