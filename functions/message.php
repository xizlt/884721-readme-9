<?php

/**
 * Возвращает массив с сообщениями, где получатель или отправитель является данный пользователь
 * @param array $messages
 * @param int $user
 * @return array|null
 */
function my_dialogs(array $messages, int $user): ?array
{
    $my_dialog = [];

    foreach ($messages as $message ) {

        if ($message['sender_id'] !== $user['id']) {
            $my_dialog[]+= $message['sender_id'];
        }
        if ($message['recipient_id'] !== $user['id']) {
            $my_dialog[]+= $message['recipient_id'];
        }
    }
    return $my_dialog;
}


function clips_text_message(string $text, int $length = 20): string
{
    $length_content = mb_strlen($text);
    $total = 0;

    if ($length_content > $length) {
        $result_words = [];
        $words = explode(" ", $text);
        foreach ($words as $word) {
            $num = mb_strlen($word);
            $total += $num;
            if ($total >= $length) {
                break;
            }
            $result_words[] = $word;

        }
        return implode(' ',
                $result_words) . ' ...';
    }
    return $text;
}

