<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://jcat.tk/
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Вывод расписания
=====================================
*/
 if (! defined ('JRE_KEY')) {
    die ( "Hacking attempt!" );
 }
//доделать
 include( ENGINE_DIR . '/data/db_config.php' );
 include( ENGINE_DIR . '/classes/db_connect.class.php' );

 $days = '<div class="schedule">
            <span><a href="/schedule/monday">Понедельник</a></span>
            <span><a href="/schedule/tuesday">Вторник</a></span>
            <span><a href="/schedule/wednesday">Среда</a></span>
            <span><a href="/schedule/thursday">Четверг</a></span>
            <span><a href="/schedule/friday">Пятница</a></span>
            <span><a href="/schedule/saturday">Суббота</a></span>
            <span><a href="/schedule/sunday">Воскресенье</a></span>
          </div>';

 $show = isset($_GET['show'])  ? $_GET['show'] : false;
	switch($show)
	{
        case 'all':
            $content = $days;
            $content .= '<div class="schedule">Выберите день недели</div>';
            $tpl -> set( "{content}", $content );
		break;
        
        case 'day':
            $day = $_GET['day'];
            $content = $days;
            $stmt = $pdo->prepare('SELECT * FROM jre_schedule WHERE day = :day ORDER BY time ASC');
            $stmt->execute(array('day' => $day));
            while($row = $stmt->fetch()){
                $tpl -> set( "{time}", date("H:i",$row["time"]) );
                $tpl -> set( "{title}", $row["title"] );
                $content .= $tpl -> showmodule( "schedule.tpl" );
            }
            $tpl -> set( "{content}", $content );
		break;
	}
    
 $pdo = null;
?>