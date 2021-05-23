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
include (ENGINE_DIR . '/classes/config_loader.php');
include (ENGINE_DIR . '/classes/menu.php');

session_start();
ob_start();

$config = ConfigLoader::load('config');
$db_config = ConfigLoader::load('db_config');
$template = ENGINE_DIR . "/admin/";
include (ENGINE_DIR . '/classes/user.php');

if (isset($_SESSION['auth']) && $user->get('is_admin') == true)
{
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
        case 'settings':
        case 'rj':
        case 'users':
        case 'users_group':
            require_once(ENGINE_DIR . '/admin/'. $do .'.php');
        break;
    }
    $content = ob_get_clean();
    include $template . 'admin.php';
} else {
    header("HTTP/1.1 404 Not Found");
    exit();
}