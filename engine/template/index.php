<?php
/*
=======================================
 JCat Radio Engine
---------------------------------------
 *site*
---------------------------------------
 Copyright (c) 2016-2017 Molchanov A.I.
=======================================
 Обработка главной страницы
=======================================
*/
if (!defined('JRE_KEY')) die("Hacking attempt!");
switch ($config->main_page) {
	case 2:
		$_GET['show'] = 'shortnews';
		include ENGINE_DIR . '/template/news.php';
		break;
	
	case 1:
	default:
		$tpl->set('{content}', $tpl->show('index'));
		break;
}