<?php
/*
=====================================
 JCat Light Engine
-------------------------------------
 http://jcat.tk/
-------------------------------------
 Copyright (c) 2016 Molchanov. A.I.
=====================================
 Главный обработчик движка
=====================================
*/
 if (! defined ('JLE_KEY')) {
    die ( "Hacking attempt!" );
 }

 include( ENGINE_DIR . '/data/config.php' );
 include( ENGINE_DIR . '/classes/template.class.php' );
 $tpl_dir = '/pages';
 $tpl -> template = ROOT_DIR . $tpl_dir;
 $tpl -> set( "{dir}", $tpl_dir );

 $page = isset($_GET['page'])  ? $_GET['page'] : false;
	switch($page)
	{
		default:
			require_once ( ENGINE_DIR . '/template/index.php');
		break;
/*
		case 'registration':
            require_once ( ENGINE_DIR . '/template/registration.php');
            $tpl -> set( "{content}", $tpl -> showmodule( "registration.tpl" ) );
		break;
*/
        case 'play':
            require_once ( ENGINE_DIR . '/template/play.php');
		break;
        
        case 'news':
            require_once ( ENGINE_DIR . '/template/news.php');
		break;

	}

    $head = '
        <meta charset="' . $config['charset'] . '">
        <meta name="description" content="' . $config['description'] . '"> 
        <meta name="keywords" content="' . $config['keywords'] . '">
    ';
    
    if (empty($page_title)) {
        $head .= '<title>'. $config['home_title'] .'</title>';
    }
    else {
        $head .= '<title>' . $page_title .'&raquo;'. $config['home_title'] .'</title>';
    }
    
    $tpl -> set( "{head}", $head );
    $tpl -> set( "{footer}", $tpl -> showmodule( "footer.tpl" ) );
	$tpl -> showtemplate();
?>