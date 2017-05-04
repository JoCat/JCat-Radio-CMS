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

include (ENGINE_DIR . '/classes/user.php');
$config = ConfigLoader::load('config');
$db_config = ConfigLoader::load('db_config');
$template = ENGINE_DIR . "/admin/";

$do = isset($_GET['do']) ? $_GET['do'] : false;
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
$content = ob_get_clean();
include $template . 'admin.php';
