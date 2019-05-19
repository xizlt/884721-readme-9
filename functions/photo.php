<?php


function upload_img_by_url($post_data)
{
    if ($post_data) {
        $path = 'uploads/' . basename($post_data);
        $file = file_get_contents($post_data);
        file_put_contents($path, $file);
        return $path;
    }
    return null;
}