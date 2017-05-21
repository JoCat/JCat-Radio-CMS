<?php
/*
=======================================
 JCat Radio Engine
---------------------------------------
 *site*
---------------------------------------
 Copyright (c) 2016-2017 Molchanov A.I.
=======================================
 Авторизация пользователя
=======================================
*/
if (!defined('JRE_KEY')) die ("Hacking attempt!");
include (ENGINE_DIR . '/classes/db_connect.php');
include (ENGINE_DIR . '/classes/helpers.php');

if (!empty($_POST))
{
    if (empty($_POST['login'])) $helpers->addMessage('Не введен Логин', true);
    if (empty($_POST['pass'])) $helpers->addMessage('Не введен Пароль', true);
    if (empty($helpers->msg))
    {
        $stmt = $pdo->prepare('SELECT * FROM `users` JOIN `user_groups` ON users.usergroup_id = user_groups.id WHERE `login` = :login AND `status` = 1');
        $stmt->bindValue(':login', $_POST['login'], PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch();
        if (empty($row))
        {
            $helpers->addMessage('Логин <b>' . htmlentities($_POST['login']) . '</b> не найден!', true);
        } else {
            if (password_verify($_POST['pass'], $row['password'])) {
                $_SESSION['user_data'] = [
                    'username' => $row['login'],
                    'usergroup' => $row['name']
                ];
                header('Location:http://' . $_SERVER['HTTP_HOST']);
                exit;
            } else {
                $helpers->addMessage('Неверный пароль!', true);
            }
        }
    }
}
include $template . '/auth.php';
