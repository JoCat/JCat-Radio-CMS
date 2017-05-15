<?php
/*
=======================================
 JCat Radio Engine
---------------------------------------
 *site*
---------------------------------------
 Copyright (c) 2016-2017 Molchanov A.I.
=======================================
 Регистрация пользователя
=======================================
*/
if (!defined ('JRE_KEY')) die ("Hacking attempt!");
include(ENGINE_DIR . '/classes/db_connect.php');
include(ENGINE_DIR . '/classes/helpers.php');

if (isset($_GET['status']) && $_GET['status'] == 'ok') $helpers->addMessage('Вы успешно зарегистрировались! Пожалуйста активируйте свой аккаунт!');
if (isset($_GET['active']) && $_GET['active'] == 'ok')
{
    header('Refresh:3; URL=http://'. $_SERVER['HTTP_HOST'] .'/admin.php');
    $helpers->addMessage('Ваш аккаунт успешно активирован!');
}
if (isset($_GET['key']))
{
    $stmt = $pdo->prepare('SELECT * FROM `users` WHERE `active_hex` = :key');
    $stmt->bindValue(':key', $_GET['key'], PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch();
    if (!empty($row))
    {
        $stmt = $pdo->prepare('UPDATE `users` SET `status` = 1 WHERE `login` = :login');
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
    if (empty($helpers->msg))
    {
        if ($_POST['pass'] != $_POST['pass2']) $helpers->addMessage('Пароли не совподают', true);
        if (empty($helpers->msg))
        {
            $stmt = $pdo->prepare('SELECT `login` FROM `users` WHERE `login` = :login');
            $stmt->bindValue(':login', $_POST['login'], PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch();
            if (!empty($row)) $helpers->addMessage('Пользователь с логином: <b>'. $_POST['login'] .'</b> уже зарегестрирован!', true);
            if (empty($helpers->msg))
            {
                $stmt = $pdo->prepare('SELECT `email` FROM `users` WHERE `email` = :email');
                $stmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
                $stmt->execute();
                $row = $stmt->fetch();
                if (!empty($row)) $helpers->addMessage('Пользователь с почтой: <b>'. $_POST['email'] .'</b> уже зарегестрирован!', true);
                if (empty($helpers->msg))
                {
                    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
                    $key = md5($_POST['login'] . time());
                    $sql = 'INSERT INTO `users`(`login`, `password`, `email`, `active_hex`, `status`) VALUES (:login, :pass, :email, :key, 0)';
                    //Подготавливаем PDO выражение для SQL запроса
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':login', $_POST['login'], PDO::PARAM_STR);
                    $stmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
                    $stmt->bindValue(':pass', $pass, PDO::PARAM_STR);
                    $stmt->bindValue(':key', $key, PDO::PARAM_STR);
                    $stmt->execute();
                    
                    //Отправляем письмо для активации
                    $url = 'http://'. $_SERVER['HTTP_HOST'] .'/admin.php?do=reg&key='. $key;
                    $message = <<<MSG
<html>
  <head>
    <title>Регистрация на сайте {$_SERVER['HTTP_HOST']} </title>
  </head>
  <body>
    <p>Для активации Вашего аккаунта пройдите по ссылке: </p>
    <a href="$url">Активация аккаунта</a>
  </body>
</html>
MSG;
                    
                   //Формируем заголовки для почтового сервера
                   $headers = "MIME-Version: 1.0\r\n";
                   $headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
                   $headers .= "To: ". $_POST['email'] . "\r\n";
                   $headers .= "From: ". $config->admin_mail ."\r\n";
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
include $template . '/reg.php';
