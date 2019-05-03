<?php

function square($num)
{
    return $num * $num;
}

$data = [
    [
        'num' => 2,
        'expected' => 4
    ],
    [
        'num' => 3,
        'expected' => 9
    ]
];

foreach ($data as $test_case) {

    $result = square($test_case['num']);

    if ($result !== $test_case['expected']) {
        var_dump($test_case);
        var_dump($result);
        die('Тест функции square не пройден!!!');
    }
}
echo 'Тест функция square успешна пройдена';