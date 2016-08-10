<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://radiocms.tk
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Вывод расписания
=====================================
*/
 if (! defined ('JRE_KEY')) {
    die ( "Hacking attempt!" );
 }
 include( ENGINE_DIR . '/data/db_config.php' );
 include( ENGINE_DIR . '/classes/db_connect.php' );
 $page_title = 'Расписание';
 
 $stmt = $pdo->prepare('SELECT * FROM jre_schedule WHERE day = :day ORDER BY time ASC');
 $days = array(
 'monday' => 'Понедельник',
 'tuesday' => 'Вторник',
 'wednesday' => 'Среда',
 'thursday' => 'Четверг',
 'friday' => 'Пятница',
 'saturday' => 'Суббота',
 'sunday' => 'Воскресенье'
 );
 
 foreach ($days as $key => $value) {
    $day = '<div class="day">'.$value.'</div>';
    $stmt->execute(array('day' => $key));
    while($row = $stmt->fetch()){
        if (!empty ($row)){
            $tpl -> set( "{title}", $row["title"] );
            $tpl -> set( "{time}", date("H:i",$row["time"]) );
            $tpl -> set( "{endtime}", date("H:i",$row["endtime"]) );
            $blocks .= $tpl -> showmodule( "schedule.tpl" );
        }
    }
    if (!empty ($blocks))
        $content .= '<div class="day-block">'. $day . $blocks .'</div>';
    $div = null; $blocks = null;
 }
 if (empty ($content)){
    $content = '<div class="error-alert">
    <b>Внимание! Обнаружена ошибка</b><br>
    На данный момент у нас нет расписания, заходите позже :)
    </div>';
 }
 $tpl -> set( "{content}", $content );
 $pdo = null;
?>