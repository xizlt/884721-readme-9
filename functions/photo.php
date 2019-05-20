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

/**
 * Проверяет загруженный файл по MIME типу
 * @param string $file_type
 * @return bool
 */
function is_image(string $file_type): bool
{
    switch ($file_type) {
        case 'image/gif':
            return true;
        case 'image/jpeg':
            return true;
        case 'image/png':
            return true;
    }
    return false;
}