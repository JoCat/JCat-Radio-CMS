<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://jcat.tk/
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Обработчик Админпанели
=====================================
*/
 if (! defined ('JRE_KEY')) {
    die ( "Hacking attempt!" );
 }

 include ( ENGINE_DIR . '/data/config.php' );
 session_start();

 $do = isset($_GET['do'])  ? $_GET['do'] : false;
 if ($_SESSION['user'] == 'true'){
    switch($do)
	{
        case 'exit':
            session_destroy();
            header('Location:http://'. $_SERVER['HTTP_HOST']);
        break;

        case 'config':
            require_once ( ENGINE_DIR . '/admin/config.php');
        break;

        case 'news':
            require_once ( ENGINE_DIR . '/admin/news.php');
        break;

        case 'rj':
            require_once ( ENGINE_DIR . '/admin/rj.php');
        break;

        case 'programs':
            require_once ( ENGINE_DIR . '/admin/programs.php');
        break;

        case 'schedule':
            require_once ( ENGINE_DIR . '/admin/schedule.php');
        break;

        case 'static':
            require_once ( ENGINE_DIR . '/admin/static.php');
        break;

        default:
			require_once ( ENGINE_DIR . '/admin/main.php');
		break;
    }
 }
  else {
    switch($do)
	{
        default:
            require_once ( ENGINE_DIR . '/admin/auth.php');
        break;

        case 'reg':
            require_once ( ENGINE_DIR . '/admin/reg.php');
        break;

        case 'lostpassword':
            require_once ( ENGINE_DIR . '/admin/lostpassword.php');
        break;
    }
 }

 echo "\n<!-- Powered by JRE " . $config['jre_version'] . " -->\r\n";
?>