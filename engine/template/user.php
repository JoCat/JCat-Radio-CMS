<?php
/*
=======================================
 JCat Radio Engine
---------------------------------------
 *site*
---------------------------------------
 Copyright (c) 2016-2017 Molchanov A.I.
=======================================
 Вывод страницы пользователя
=======================================
*/
if (!defined('JRE_KEY')) die("Hacking attempt!");
include (ENGINE_DIR . '/classes/db_connect.php');

$stmt = $pdo->prepare('SELECT * FROM `users` INNER JOIN `user_groups` ON users.usergroup_id = user_groups.id WHERE users.login = :login');
$stmt->execute(['login' => $_GET['username']]);
if (empty($data = $stmt->fetch())) {
    $content = '<div class="error-alert">
    <b>Внимание! Обнаружена ошибка.</b><br>
    Пользователь не найден.
    </div>';
} else {
    $tpl->set('{username}', $data['login']);
    $tpl->set('{usergroup}', $data['name']);
    $content = $tpl->show('userpage');
}

$tpl->set('{content}', $content);
