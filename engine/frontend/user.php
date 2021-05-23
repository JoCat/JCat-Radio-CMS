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

include(ENGINE_DIR . '/classes/db_connect.php');

$stmt = $pdo->prepare('SELECT * FROM `users` JOIN `user_groups` ON users.usergroup_id = user_groups.id WHERE users.login = :login');
$stmt->execute(['login' => $_GET['username']]);
if (empty($result = $stmt->fetch())) {
    echo '<div class="error-alert">
    <b>Внимание! Обнаружена ошибка.</b><br>
    Пользователь не найден.
    </div>';
} else {
    $user_info = [
        'username' => $result->login,
        'usergroup' => $result->name,
        'image' => empty($result->image) ?
            '/template/' . $config->tpl_dir . '/images/no_avatar.png' :
            '/uploads/images/users/' . $result->image
    ];
    include $template . '/userpage.php';
}
