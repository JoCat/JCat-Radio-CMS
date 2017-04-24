<?php
/*
=======================================
 JCat Radio Engine
---------------------------------------
 *site*
---------------------------------------
 Copyright (c) 2016-2017 Molchanov A.I.
=======================================
 Обработчик Админпанели
=======================================
*/
if (!defined('JRE_KEY')) die("Hacking attempt!");
include (ENGINE_DIR . '/classes/config_loader.php');
session_start();
ob_start();

$config = ConfigLoader::load('config');
$db_config = ConfigLoader::load('db_config');
$template = ENGINE_DIR . "/admin/";

$do = isset($_GET['do']) ? $_GET['do'] : false;
if (!empty($_SESSION['auth']))
{
    $tplt = 'admin.php';
    switch($do)
    {
        default:
            require_once(ENGINE_DIR . '/admin/main.php');
        break;

        case 'logout':
            session_destroy();
            header('Location:http://'. $_SERVER['HTTP_HOST']);
        break;

        case 'news':
        case 'programs':
        case 'schedule':
        case 'static':
            require_once(ENGINE_DIR . '/admin/'. $do .'.php');
            // menu 1
        break;

        case 'settings':
            require_once(ENGINE_DIR . '/admin/'. $do .'.php');
            // menu 2
        break;
    }
} else {
    $tplt = 'auth.php';
    switch($do)
    {
        default:
            require_once(ENGINE_DIR . '/admin/login.php');
        break;

        case 'reg':
        case 'lostpassword':
            require_once(ENGINE_DIR . '/admin/'. $do .'.php');
        break;
    }
}
$content = ob_get_clean();
include $template . $tplt;