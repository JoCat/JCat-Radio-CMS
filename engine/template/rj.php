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
            $showrj = $config['showrj'];
            $db_rj = $config['db_rj'];
            $result = @mysql_query("SELECT * FROM $db_rj ORDER BY date DESC LIMIT 0,$showrj;");
            
            while($row=@mysql_fetch_array($result)){
                $tpl -> set( "{name}", $row["name"] );
                $tpl -> set( "{description}", $row["description"] );
                $content .= $tpl -> showmodule( "rjblock.tpl" );
            }
            $tpl -> set( "{content}", $content );
		break;
        
        case 'rj':
            $page_title = $row["name"];
            //Temporarily not working
            $tpl -> set( "{content}", $tpl -> showmodule( "rjpage.tpl" ) );
		break;
	}
    
 @mysql_close();
?>