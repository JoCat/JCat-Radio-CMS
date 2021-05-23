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

switch ($config->main_page) {
	case 2:
		$_GET['show'] = 'shortnews';
		include ENGINE_DIR . '/frontend/news.php';
		break;

	case 1:
	default:
		include $template . '/index.php';
		break;
}
