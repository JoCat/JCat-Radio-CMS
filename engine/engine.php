<?php
/*
=======================================
 JCat Radio Engine
---------------------------------------
 *site*
---------------------------------------
 Copyright (c) 2016-2017 Molchanov A.I.
=======================================
 Главный обработчик движка
=======================================
*/
if (!defined('JRE_KEY')) die("Hacking attempt!");
include (ENGINE_DIR . '/classes/config_loader.php');
include (ENGINE_DIR . '/classes/template.php');

$config = ConfigLoader::load('config');
$db_config = ConfigLoader::load('db_config');
$tpl = new Template($config->tpl_dir);

$do = isset($_GET['do']) ? $_GET['do'] : false;
switch($do)
{
    case 'news':
    case 'programs':
    case 'schedule':
    case 'static':
    case 'user':
        require_once(ENGINE_DIR . '/template/'. $do .'.php');
    break;

    default:
        require_once(ENGINE_DIR . '/template/index.php');
    break;
}

$head = empty($seo_title) ? '<title>'. $config->title .'</title>' : '<title>'. $seo_title .'</title>';
$head .= empty($seo_description) ? '<meta name="description" content="' . $config->description . '">' : '<meta name="description" content="' . $seo_description . '">';
$head .= empty($seo_keywords) ? '<meta name="keywords" content="' . $config->keywords . '">' : '<meta name="keywords" content="' . $seo_keywords . '">';
$tpl->set("{head}", $head);
$tpl->set("{dir}", '/template/' . $config->tpl_dir);
if (!isset($_SERVER['HTTP_X_PJAX'])) {
    die($tpl->show('main'));
} else {
    die($tpl->show('ajax'));
}
