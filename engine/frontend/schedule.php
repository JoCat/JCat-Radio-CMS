<?php
/*
=======================================
 JCat Radio CMS
---------------------------------------
 https://radio-cms.ru/
---------------------------------------
 Copyright (c) 2016-2021 Molchanov A.I.
=======================================
 Вывод расписания
=======================================
*/

require_once ENGINE_DIR . '/classes/db_connect.php';
require_once ENGINE_DIR . '/classes/helpers.php';

$seo_title = 'Расписание &raquo; ' . $config->title;

$stmt = $pdo->prepare('SELECT * FROM `schedule` JOIN `programs` ON schedule.program_id = programs.id WHERE schedule.day = :day AND schedule.show = 1 ORDER BY schedule.start_time ASC');
$days = [
    'monday' => 'Понедельник',
    'tuesday' => 'Вторник',
    'wednesday' => 'Среда',
    'thursday' => 'Четверг',
    'friday' => 'Пятница',
    'saturday' => 'Суббота',
    'sunday' => 'Воскресенье'
];

foreach ($days as $key => $value) {
    $stmt->execute(['day' => $key]);
    while ($row = $stmt->fetch()) {
        $schedule[$key][] = [
            'title' => $row->title,
            'start_time' => $helpers->get_time($row->start_time),
            'end_time' => $helpers->get_time($row->end_time),
        ];
    }
}
if (empty($schedule)) {
    echo '<div class="error-alert">
    <b>Внимание! Обнаружена ошибка.</b><br>
    На данный момент у нас нет расписания, заходите позже :)
    </div>';
} else {
    require_once $template . '/schedule.php';
}
