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
include (ENGINE_DIR . '/classes/template.php');
session_start();
ob_start();

$config = ConfigLoader::load('config');
$db_config = ConfigLoader::load('db_config');
$tpl = new Template('');
$tpl->template = ENGINE_DIR . "/admin";

$do = isset($_GET['do']) ? $_GET['do'] : false;
if (isset($_SESSION['auth']) && $_SESSION['auth'] == 'true')
{
    $tplt = 'admin';
    switch($do)
    {
        case 'logout':
            session_destroy();
            header('Location:http://'. $_SERVER['HTTP_HOST']);
        break;

        case 'settings':
        case 'news':
        case 'rj':
        case 'programs':
        case 'schedule':
        case 'static':
        case 'widgets':
            require_once(ENGINE_DIR . '/admin/'. $do .'.php');
        break;

        default:
            require_once(ENGINE_DIR . '/admin/main.php');
        break;
    }
    $tpl->set("{username}", $_SESSION['username']);
    $tpl->set("{usergroup}", $_SESSION['usergroup']);
} else {
    $tplt = 'auth';
    switch($do)
    {
        case 'reg':
        case 'lostpassword':
            require_once(ENGINE_DIR . '/admin/'. $do .'.php');
        break;

        default:
            require_once(ENGINE_DIR . '/admin/auth.php');
        break;
    }
}
$tpl->set("{content}", ob_get_clean());
die($tpl->show($tplt));
