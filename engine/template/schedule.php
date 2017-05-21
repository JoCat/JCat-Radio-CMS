<?php
/*
=======================================
 JCat Radio Engine
---------------------------------------
 *site*
---------------------------------------
 Copyright (c) 2016-2017 Molchanov A.I.
=======================================
 Вывод расписания
=======================================
*/
if (!defined('JRE_KEY')) die("Hacking attempt!");
include (ENGINE_DIR . '/classes/db_connect.php');

$page_title = 'Расписание &raquo; '. $config->title;
$content = '';

$stmt = $pdo->prepare('SELECT * FROM `schedule` WHERE day = :day ORDER BY start_time ASC');
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
    $blocks = '';
    $day = '<div class="day">' . $value . '</div>';
    $stmt->execute(['day' => $key]);
    while($row = $stmt->fetch()) {
        if (!empty($row)) {
            $tpl->set("{title}", $row["title"]);
            $tpl->set("{start_time}", $row["start_time"]);
            $tpl->set("{end_time}", $row["end_time"]);
            $blocks .= $tpl->show("schedule");
        }
    }
    if (!empty($blocks)) $content .= '<div class="day-block">'. $day . $blocks .'</div>';
}
if (empty($content)){
    $content = '<div class="error-alert">
    <b>Внимание! Обнаружена ошибка.</b><br>
    На данный момент у нас нет расписания, заходите позже :)
    </div>';
}
$tpl->set("{content}", $content);
