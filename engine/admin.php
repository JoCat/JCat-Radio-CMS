<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://radiocms.tk
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
        case 'news':
        case 'rj':
        case 'programs':
        case 'schedule':
        case 'static':
        case 'widgets':
            require_once ( ENGINE_DIR . '/admin/'.$do.'.php');
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

 echo "<!-- Powered by JRE " . $config['jre_version'] . " -->";
?>