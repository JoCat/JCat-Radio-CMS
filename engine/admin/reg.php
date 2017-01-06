<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://radiocms.tk
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Регистрация пользователя
=====================================
*/
if (!defined ('JRE_KEY')) die ("Hacking attempt!");
include(ENGINE_DIR . '/data/db_config.php');
include(ENGINE_DIR . '/classes/db_connect.php');
include(ENGINE_DIR . '/classes/auth_functions.php');

if (isset($_GET['status']) && $_GET['status'] == 'ok') $helpers->addMessage('Вы успешно зарегистрировались! Пожалуйста активируйте свой аккаунт!');
if (isset($_GET['active']) && $_GET['active'] == 'ok')
{
    header('Refresh:3; URL=http://'. $_SERVER['HTTP_HOST'] .'/admin.php');
    $helpers->addMessage('Ваш аккаунт успешно активирован!');
}
if (isset($_GET['key']))
{
    $stmt = $pdo->prepare('SELECT * FROM `jre_users` WHERE `active_hex` = :key');
    $stmt->bindValue(':key', $_GET['key'], PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch();
    if (!empty($row))
    {
        $stmt = $pdo->prepare('UPDATE `jre_users` SET `status` = 1 WHERE `login` = :login');
        $stmt->bindValue(':login', $row['login'], PDO::PARAM_STR);
        $stmt->execute();
        header('Location:http://'. $_SERVER['HTTP_HOST'] .'/admin.php?do=reg&active=ok');
        exit;
    } else {
        $helpers->addMessage('Ключ активации не верен!', true);
    }
}
if (isset($_POST['submit']))
{
    if (empty($_POST['login'])) $helpers->addMessage('Поле Логин не может быть пустым', true);
    if (empty($_POST['email'])) {
        $helpers->addMessage('Поле Email не может быть пустым!', true);
    } else {
        if ($helpers->emailValid($_POST['email']) === false) $helpers->addMessage('Не правильно введен E-mail', true);
    }
    if (empty($_POST['pass'])) $helpers->addMessage('Поле Пароль не может быть пустым', true);
    if (empty($_POST['pass2'])) $helpers->addMessage('Поле подтверждения пароля не может быть пустым', true);
    if (empty($_POST['key'])) $helpers->addMessage('Поле ключа защиты не может быть пустым!', true);
    if (empty($helpers->msg))
    {
        if ($_POST['pass'] != $_POST['pass2']) $helpers->addMessage('Пароли не совподают', true);
        if ($_POST['key'] != $config['reg_key']) $helpers->addMessage('Не правильно введен ключ защиты!', true);
        if (empty($helpers->msg))
        {
            $stmt = $pdo->prepare('SELECT `login` FROM `jre_users` WHERE `login` = :login');
            $stmt->bindValue(':login', $_POST['login'], PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetch();
            if (empty($row)) $helpers->addMessage('Пользователь с логином: <b>'. $_POST['login'] .'</b> уже зарегестрирован!', true);
            if (empty($helpers->msg))
            {
                $stmt = $pdo->prepare('SELECT `email` FROM `jre_users` WHERE `email` = :email');
                $stmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
                $stmt->execute();
                $row = $stmt->fetch();
                if (empty($row)) $helpers->addMessage('Пользователь с почтой: <b>'. $_POST['email'] .'</b> уже зарегестрирован!', true);
                if (empty($helpers->msg))
                {
                    $salt = $helpers->salt();
                    $pass = md5(md5($_POST['pass']).$salt);
                    $sql = 'INSERT INTO `jre_users`(`login`, `pass`, `email`, `salt`, `active_hex`, `status`) VALUES (:login, :pass, :email, :salt, "'. md5($salt) .'", 0)';
                    //Подготавливаем PDO выражение для SQL запроса
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':login', $_POST['login'], PDO::PARAM_STR);
                    $stmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
                    $stmt->bindValue(':pass', $pass, PDO::PARAM_STR);
                    $stmt->bindValue(':salt', $salt, PDO::PARAM_STR);
                    $stmt->execute();
                    
                    //Отправляем письмо для активации
                    $url = 'http://'. $_SERVER['HTTP_HOST'] .'/admin.php?do=reg&key='. md5($salt);
                    $message = '
                    <html>
                    <head>
                      <title>Регистрация на сайте '. $_SERVER['HTTP_HOST'] .'</title>
                    </head>
                    <body>
                      <p>Для активации Вашего аккаунта пройдите по ссылке: </p>
                      <a href="'. $url .'">Активация аккаунта</a>
                    </body>
                    </html>
                    ';
                    
                   //Формируем заголовки для почтового сервера
                   $headers = "MIME-Version: 1.0\r\n";
                   $headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
                   $headers .= "To: ". $_POST['email'] . "\r\n";
                   $headers .= "From: ". $config['admin_mail'] ."\r\n";
                   $headers .= "Date: ". date('D, d M Y h:i:s O');

                   //Отправляем данные на почту
                   mail($_POST['email'], 'Регистрация на сайте ' . $_SERVER['HTTP_HOST'], $message, $headers);
                    
                    //Сбрасываем параметры
                    header('Location:http://'. $_SERVER['HTTP_HOST'] .'/admin.php?do=reg&status=ok');
                    exit;
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация &raquo; Админпанель</title>
    <link rel="stylesheet" type="text/css" href="/engine/admin/styles/auth.css">
</head>
<body>
    <?php $helpers->showMessage(); ?>
    <div class="form" style="height:455px;">
        <div class="header">Регистрация</div>
        <form action="" method="POST">
            Логин:
            <input required placeholder="Введите логин" type="text" name="login">
            Пароль:
            <input required placeholder="Введите пароль" type="password" name="pass">
            Повторите пароль:
            <input required placeholder="Повторите пароль" type="password" name="pass2">
            E-mail:
            <input required placeholder="Введите E-Mail" type="text" name="email">
            Ключ защиты:
            <input required placeholder="Введите ключ защиты" type="text" name="key">
            <button type="submit" name="submit">Отправить</button>
            <div class="links">
                <a href="/admin.php">Авторизация</a><br>
                <a href="/admin.php?do=lostpassword">Забыли пароль?</a>
            </div>
        </form>
    </div>
</body>
</html>