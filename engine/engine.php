<?php
/*
=======================================
 JCat Radio Engine
---------------------------------------
 *site*
---------------------------------------
 Copyright (c) 2016-2019 Molchanov A.I.
=======================================
 Главный обработчик движка
=======================================
*/
include ENGINE_DIR . '/classes/config_loader.php';
session_start();
ob_start();

$config = ConfigLoader::load('config');
$db_config = ConfigLoader::load('db_config');
$template = ROOT_DIR . '/template/' . $config->tpl_dir;
include ENGINE_DIR . '/classes/user.php';
// include ENGINE_DIR . '/classes/stats.php';

$do = isset($_GET['do']) ? $_GET['do'] : null;
switch ($do) {
    default:
        require_once(ENGINE_DIR . '/frontend/index.php');
        break;

    case 'news':
    case 'programs':
    case 'schedule':
    case 'static':
    case 'user':
    case 'auth':
    case 'reg':
        require_once(ENGINE_DIR . '/frontend/' . $do . '.php');
        break;

    case 'logout':
        session_destroy();
        header('Location:http://' . $_SERVER['HTTP_HOST']);
        break;
}
$content = ob_get_clean();

$head = empty($seo_title) ? '<title>' . $config->title . '</title>' : '<title>' . $seo_title . '</title>';
$head .= empty($seo_description) ? '<meta name="description" content="' . $config->description . '">' : '<meta name="description" content="' . $seo_description . '">';
$head .= empty($seo_keywords) ? '<meta name="keywords" content="' . $config->keywords . '">' : '<meta name="keywords" content="' . $seo_keywords . '">';

if (!isset($_SERVER['HTTP_X_PJAX'])) {
    include $template . '/main.php';
} else {
    echo $head, $content;
}
