<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://radiocms.tk
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Авторизация пользователя
=====================================
*/
if (!defined('JRE_KEY')) die ("Hacking attempt!");
include(ENGINE_DIR . '/data/db_config.php');
include(ENGINE_DIR . '/classes/db_connect.php');
include(ENGINE_DIR . '/classes/auth_functions.php');

if (isset($_POST['submit']))
{
    if (empty($_POST['login'])) $helpers->addMessage('Не введен Логин', true);
    if (empty($_POST['pass'])) $helpers->addMessage('Не введен Пароль', true);
    if (empty($helpers->msg))
    {
        $stmt = $pdo->prepare('SELECT * FROM `jre_users` WHERE `login` = :login AND `status` = 1');
        $stmt->bindValue(':login', $_POST['login'], PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch();
        if (!empty($row))
        {
            if (md5(md5($_POST['pass']).$row['salt']) == $row['pass'])
            {
                $_SESSION['auth'] = true;
                header('Location:http://'. $_SERVER['HTTP_HOST'] .'/admin.php');
                exit;
            } else {
                $helpers->addMessage('Неверный пароль!', true);
            }
        } else {
            $helpers->addMessage('Логин <b>'. $_POST['login'] .'</b> не найден!', true);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Авторизация &raquo; Админпанель</title>
    <link rel="stylesheet" type="text/css" href="/engine/admin/styles/auth.css">
</head>
<body>
    <?php $helpers->showMessage(); ?>
    <div class="form" style="height:244px;">
        <div class="header">Панель управления<br>JCat Radio Engine</div>
        <form action="" method="POST">
            <input required placeholder="Логин" type="text" name="login">
            <input required placeholder="Пароль" type="password" name="pass">
            <button type="submit" name="submit">Войти</button>
            <div class="links">
                <a href="/admin.php?do=reg">Регистрация</a><br>
                <a href="/admin.php?do=lostpassword">Забыли пароль?</a>
            </div>
        </form>
    </div>
</body>
</html>