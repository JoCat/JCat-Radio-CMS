<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://jcat.tk/
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Главный обработчик движка
=====================================
*/
 if (! defined ('JRE_KEY')) {
    die ( "Hacking attempt!" );
 }

 include( ENGINE_DIR . '/data/config.php' );
 include( ENGINE_DIR . '/classes/template.class.php' );
 $tpl_dir = '/pages';
 $tpl -> template = ROOT_DIR . $tpl_dir;
 $tpl -> set( "{dir}", $tpl_dir );

 $do = isset($_GET['do'])  ? $_GET['do'] : false;
	switch($do)
	{
		default:
			require_once ( ENGINE_DIR . '/template/main.php');
		break;

        case 'news':
            require_once ( ENGINE_DIR . '/template/news.php');
		break;

        case 'rj':
            require_once ( ENGINE_DIR . '/template/rj.php');
		break;

        case 'programs':
            require_once ( ENGINE_DIR . '/template/programs.php');
		break;

        case 'schedule':
            require_once ( ENGINE_DIR . '/template/schedule.php');
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
        $head .= '<title>' . $page_title .' &raquo; '. $config['home_title'] .'</title>';
    }
    
    $tpl -> set( "{head}", $head );
    $tpl -> set( "{adm_mail}", $config['admin_mail'] );
    $tpl -> showtemplate('/main.tpl');
    echo "\n<!-- Powered by JRE v0.5 -->\r\n";
?>