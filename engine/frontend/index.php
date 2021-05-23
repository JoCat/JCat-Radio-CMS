<?php
/*
=======================================
 JCat Radio CMS
---------------------------------------
 https://radio-cms.ru/
---------------------------------------
 Copyright (c) 2016-2021 Molchanov A.I.
=======================================
 Обработка главной страницы
=======================================
*/

switch ($config->main_page) {
    case 2:
        $_GET['show'] = 'shortnews';
        require_once ENGINE_DIR . '/frontend/news.php';
        break;

    case 1:
    default:
        require_once $template . '/index.php';
        break;
}
