<?php

/**
 * @param array $data
 * @return string
 */
function upload_img_by_url(string $data): string
{
    if ($data) {
        $path = 'uploads/' . basename($data);
        $file = file_get_contents($data);
        file_put_contents($path, $file);
        return $path;
    }
    return null;
}