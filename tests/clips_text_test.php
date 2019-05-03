<?php
require_once "../functions.php";

$data = [
    [
        'string' => 'Твоя строка для теста',
        'expected' => '<p>Твоя строка ...</p><a class="post-text__more-link" href="#">Читать далее</a>'
    ],
    [
        'string' => 'Короткая',
        'expected' => '<p>Короткая</p>'
    ]
];

foreach ($data as $test_case) {

    $result = clips_text($test_case['string'], 12);

    if ($result !== $test_case['expected']) {
        var_dump($test_case);
        var_dump($result);
        die('Тест функции clips_text не пройден!!!');
    }
}
echo 'Тест функция clips_text успешна пройдена';

