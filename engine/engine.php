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

        case 'news':
            require_once ( ENGINE_DIR . '/template/news.php');
		break;

        case 'page1':
            require_once ( ENGINE_DIR . '/template/page1.php');
		break;

        case 'page2':
            require_once ( ENGINE_DIR . '/template/page2.php');
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
    $tpl -> set( "{adm_mail}", $config['admin_mail'] );
    $tpl -> set( "{footer}", $tpl -> showmodule( "footer.tpl" ) );
	$tpl -> showtemplate();
?>