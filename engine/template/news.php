<?php
/*
=====================================
 JCat Light Engine
-------------------------------------
 http://jcat.tk/
-------------------------------------
 Copyright (c) 2016 Molchanov. A.I.
=====================================
 Вывод новостей
=====================================
*/
 if (! defined ('JLE_KEY')) {
    die ( "Hacking attempt!" );
 }

 include( ENGINE_DIR . '/data/db_config.php' );
 include( ENGINE_DIR . '/classes/db_connect.class.php' );

 $show = isset($_GET['show'])  ? $_GET['show'] : false;
	switch($show)
	{
        case 'shortnews':
            $page_title = 'Новости';
            $shownews = $config['shownews'];
            $result = @mysql_query("SELECT * FROM jle_news ORDER BY date DESC LIMIT 0,$shownews;");
            
            while($row=@mysql_fetch_array($result)){
                $tpl -> set( "{date}", date("m/d/Y - H:i",$row["date"]) );
                $tpl -> set( "{title}", $row["title"] );
                $tpl -> set( "{news}", $row["news"] );
                $content .= $tpl -> showmodule( "newsblock.tpl" );
            }
            $tpl -> set( "{content}", $content );
		break;
        
        case 'fullnews':
            $page_title = $row["title"];
            $tpl -> set( "{date}", date("m/d/Y - H:i",$row["date"]) );
            $tpl -> set( "{title}", $row["title"] );
            $tpl -> set( "{news}", $row["news"] );
            //Temporarily not working
            $tpl -> set( "{content}", $tpl -> showmodule( "fullnews.tpl" ) );
		break;
	}
    
 @mysql_close();
?>