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
if (!defined('JRE_KEY')) die("Hacking attempt!");
include (ENGINE_DIR . '/data/config.php');
include (ENGINE_DIR . '/classes/template.php');

$tpl_dir = '/pages';
$tpl->template = ROOT_DIR . $tpl_dir;
$tpl->set("{dir}", $tpl_dir);

$do = isset($_GET['do']) ? $_GET['do'] : false;
switch($do)
{
    case 'listen':
    case 'news':
    case 'rj':
    case 'programs':
    case 'schedule':
    case 'static':
        require_once(ENGINE_DIR . '/template/'. $do .'.php');
    break;

    default:
        require_once(ENGINE_DIR . '/template/main.php');
    break;
}

$head = empty($page_title) ? '<title>'. $config['title'] .'</title>' : '<title>'. $page_title .' &raquo; '. $config['title'] .'</title>';
$head .= '<meta name="description" content="' . $config['description'] . '"> 
<meta name="keywords" content="' . $config['keywords'] . '">';

$tpl->set( "{head}", $head );
$tpl->set( "{adm_mail}", $config['admin_mail'] );
$tpl->set( "{version}", $config['jre_version'] );
$tpl->showtemplate('/main.tpl');
