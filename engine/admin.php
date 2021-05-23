<?php
/*
=======================================
 JCat Radio CMS
---------------------------------------
 https://radio-cms.ru/
---------------------------------------
 Copyright (c) 2016-2021 Molchanov A.I.
=======================================
 Обработчик Админпанели
=======================================
*/

require_once ENGINE_DIR . '/classes/config_loader.php';
require_once ENGINE_DIR . '/classes/menu.php';
session_start();
ob_start();

$config = ConfigLoader::load('config');
$db_config = ConfigLoader::load('db_config');
$template = ENGINE_DIR . "/admin/";
require_once ENGINE_DIR . '/classes/user.php';

if (isset($_SESSION['auth']) && $user->get('is_admin') == true) {
    $do = isset($_GET['do']) ? $_GET['do'] : null;
    switch ($do) {
        default:
            include $template . 'main.php';
            break;

        case 'logout':
            session_destroy();
            header("Location://{$_SERVER['HTTP_HOST']}");
            break;

        case 'news':
        case 'programs':
        case 'schedule':
        case 'static':
        case 'settings':
        case 'users':
        case 'users_group':
            include $template . "$do.php";
            break;
    }
    $content = ob_get_clean();
    include $template . 'admin.php';
} else {
    header("HTTP/1.1 404 Not Found");
}
