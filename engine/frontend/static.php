<?php
/*
=======================================
 JCat Radio CMS
---------------------------------------
 https://radio-cms.ru/
---------------------------------------
 Copyright (c) 2016-2021 Molchanov A.I.
=======================================
 Вывод статических страниц
=======================================
*/
require_once ENGINE_DIR . '/classes/db_connect.php';
require_once ENGINE_DIR . '/classes/error_handler.php';

//Выполняем запрос к БД с последующим выводом страницы
$stmt = $pdo->prepare('SELECT * FROM `static_page` WHERE `url`=:url');
$stmt->execute(['url' => $_GET['url']]);
if (empty($result = $stmt->fetch())) ErrorHandler::error_notFound();
$seo_title = $result->seo_title;
$seo_description = $result->seo_description;
$seo_keywords = $result->seo_keywords;
$content = $result->content;
require_once $template . '/static.php';
