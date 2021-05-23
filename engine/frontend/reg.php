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
include ENGINE_DIR . '/classes/db_connect.php';
include ENGINE_DIR . '/classes/helpers.php';

if (isset($_GET['key'])) {
    $stmt = $pdo->prepare('SELECT * FROM `users` WHERE `active_hex` = :key');
    $stmt->bindValue(':key', $_GET['key'], PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch();
    if (!empty($row)) {
        $stmt = $pdo->prepare('UPDATE `users` SET `status` = 1 WHERE `login` = :login');
        $stmt->bindValue(':login', $row->login, PDO::PARAM_STR);
        $stmt->execute();
        header('Refresh:3; URL=http://' . $_SERVER['HTTP_HOST'] . '/auth');
        $helpers->addMessage('Ваш аккаунт успешно активирован!');
    } else {
        $helpers->addMessage('Ключ активации не верен!', true);
    }
}
if (!empty($_POST)) {
    if (empty($_POST['login'])) $helpers->addMessage('Поле Логин не может быть пустым', true);
    if (empty($_POST['email'])) {
        $helpers->addMessage('Поле Email не может быть пустым!', true);
    } else {
        if ($helpers->emailValid($_POST['email']) === false) $helpers->addMessage('Не правильно введен E-mail', true);
    }
    if (empty($_POST['pass'])) $helpers->addMessage('Поле Пароль не может быть пустым', true);
    if (empty($_POST['pass2'])) $helpers->addMessage('Поле подтверждения пароля не может быть пустым', true);
    if (empty($helpers->msg)) {
        if ($_POST['pass'] != $_POST['pass2']) $helpers->addMessage('Пароли не совпадают', true);
        if (!preg_match("/\w*/", $_POST['login'])) $helpers->addMessage('Логин может состоять только из русских и/или латинских букв, цифр, знака подчеркивания', true);
        if (empty($helpers->msg)) {
            $stmt = $pdo->prepare('SELECT `login` FROM `users` WHERE `login` = :login');
            $stmt->bindValue(':login', $_POST['login'], PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch();
            if (!empty($row)) $helpers->addMessage('Пользователь с логином: <b>' . $_POST['login'] . '</b> уже зарегестрирован!', true);
            if (empty($helpers->msg)) {
                $stmt = $pdo->prepare('SELECT `email` FROM `users` WHERE `email` = :email');
                $stmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
                $stmt->execute();
                $row = $stmt->fetch();
                if (!empty($row)) $helpers->addMessage('Пользователь с почтой: <b>' . $_POST['email'] . '</b> уже зарегестрирован!', true);
                if (empty($helpers->msg)) {
                    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
                    $key = md5($_POST['login'] . time());
                    $sql = 'INSERT INTO `users`(`login`, `password`, `email`, `active_hex`, `status`, `usergroup_id`) VALUES (:login, :pass, :email, :key, 0, 1)';
                    //Подготавливаем PDO выражение для SQL запроса
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':login', $_POST['login'], PDO::PARAM_STR);
                    $stmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
                    $stmt->bindValue(':pass', $pass, PDO::PARAM_STR);
                    $stmt->bindValue(':key', $key, PDO::PARAM_STR);
                    $stmt->execute();

                    //Отправляем письмо для активации
                    $url = 'http://' . $_SERVER['HTTP_HOST'] . '/reg/activate/' . $key;
                    $message = <<<MSG
<html>
<head>
<meta charset="utf-8">
<title>Регистрация на сайте {$_SERVER['HTTP_HOST']}</title>
<style>
body {
    margin: 0;
    font-family: sans-serif;
}
h1 {
    margin: 0;
    padding: 0.5em;
    font-size: 1.5em;
    color: #fff;
    text-align: center;
    background-color: #00bbff;
}
h2 {
    font-size: 1.2em;
}
.wrap {
    margin: 10px 5px;
}
</style>
</head>
<body>
<h1>Регистрация на сайте {$_SERVER['HTTP_HOST']}</h1>
<div class="wrap">
<h2>Для активации Вашего аккаунта пройдите по ссылке: </h2>
<a href="$url">Активация аккаунта</a>
<p>Вы получили это письмо, так как этот e-mail адрес был использован при регистрации на сайте. Если Вы не регистрировались на этом сайте, просто проигнорируйте это письмо и удалите его.<br>
Данное сообщение создано автоматически, отвечать на него не нужно.</p>
</div>
</body>
</html>
MSG;

                    //Формируем заголовки для почтового сервера
                    $headers = "MIME-Version: 1.0\r\n";
                    $headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
                    $headers .= "From: " . $config->admin_mail . "\r\n";

                    //Отправляем данные на почту
                    mail(
                        $_POST['email'],
                        '=?utf-8?B?' . base64_encode('Регистрация на сайте ' . $_SERVER['HTTP_HOST']) . '?=',
                        $message,
                        $headers
                    );

                    $helpers->addMessage('Вы успешно зарегистрировались! Пожалуйста активируйте свой аккаунт!');
                }
            }
        }
    }
}
include $template . '/reg.php';
