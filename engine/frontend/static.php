<?php
/*
=======================================
 JCat Radio Engine
---------------------------------------
 *site*
---------------------------------------
 Copyright (c) 2016-2017 Molchanov A.I.
=======================================
 Вывод статических страниц
=======================================
*/
if (!defined ('JRE_KEY')) die("Hacking attempt!");
include (ENGINE_DIR . '/classes/db_connect.php');

//Выполняем запрос к БД с последующим выводом страницы
$stmt = $pdo->prepare('SELECT * FROM `static_page` WHERE `url`=:url');
$stmt->execute(['url' => $_GET['url']]);
$result = $stmt->fetch();
if (empty($result)){
    header("HTTP/1.1 404 Not Found");
    die();
}
$seo_title = $result['seo_title'];
$seo_description = $result['seo_description'];
$seo_keywords = $result['seo_keywords'];
$content = $result['content'];
include $template . '/static.php';
