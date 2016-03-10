<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://jcat.tk/
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Вывод ведущих
=====================================
*/
 if (! defined ('JRE_KEY')) {
    die ( "Hacking attempt!" );
 }

 include( ENGINE_DIR . '/data/db_config.php' );
 include( ENGINE_DIR . '/classes/db_connect.class.php' );

 $show = isset($_GET['show'])  ? $_GET['show'] : false;
	switch($show)
	{
        case 'all':
            $page_title = 'Наши ведущие';
            $stmt = $pdo->query('SELECT * FROM jre_rj ORDER BY id ASC');
            while($row = $stmt->fetch()){
                $tpl -> set( "{name}", $row["name"] );
                $tpl -> set( "{description}", $row["description"] );
                $content .= $tpl -> showmodule( "rjblock.tpl" );
            }
            $tpl -> set( "{content}", $content );
		break;
        /*
        case 'rj':
            $page_title = $row["name"];
            //Temporarily not working
            $tpl -> set( "{content}", $tpl -> showmodule( "rjpage.tpl" ) );
		break;
        */
	}
    
 $pdo = null;
?>