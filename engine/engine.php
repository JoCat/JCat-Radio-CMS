<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://radiocms.tk
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Главный обработчик движка
=====================================
*/
 if (! defined ('JRE_KEY')) {
    die ( "Hacking attempt!" );
 }

 include ( ENGINE_DIR . '/data/config.php' );
 include ( ENGINE_DIR . '/classes/template.php' );
 $tpl_dir = '/pages';
 $tpl -> template = ROOT_DIR . $tpl_dir;
 $tpl -> set( "{dir}", $tpl_dir );

 $do = isset($_GET['do'])  ? $_GET['do'] : false;
	switch($do)
	{
		default:
			require_once ( ENGINE_DIR . '/template/main.php');
		break;

        case 'listen':
        case 'news':
        case 'rj':
        case 'programs':
        case 'schedule':
        case 'static':
            require_once ( ENGINE_DIR . '/template/'.$do.'.php');
		break;
	}

    $head = '<meta charset="utf-8">
    <meta name="description" content="' . $config['description'] . '"> 
    <meta name="keywords" content="' . $config['keywords'] . '">
    ';
    
    if (empty($page_title)) {
        $head .= '<title>'. $config['title'] .'</title>';
    } else {
        $head .= '<title>' . $page_title .' &raquo; '. $config['title'] .'</title>';
    }
    
    $tpl -> set( "{head}", $head );
    $tpl -> set( "{adm_mail}", $config['admin_mail'] );
    $tpl -> set( "{version}", $config['jre_version'] );
    $tpl -> showtemplate('/main.tpl');
    echo "<!-- Powered by JRE " . $config['jre_version'] . " -->";
?>