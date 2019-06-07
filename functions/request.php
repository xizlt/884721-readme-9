<?php

/**
 * @param array $post
 * @return array
 */
function load_user_data(array $post): array
{
    $user_data = [
        'email' => $post['email'] ?? null,
        'password' => $post['password'] ?? null,
        'password-repeat' => $post['password-repeat'] ?? null,
        'name' => $post['name'] ?? null,
        'about' => $post['about'] ?? null,
    ];
    return clean($user_data);
}
