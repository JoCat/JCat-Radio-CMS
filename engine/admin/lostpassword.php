<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://radiocms.tk
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Восстановление пароля
=====================================
*/
if (!defined ('JRE_KEY')) die("Hacking attempt!");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Восстановление пароля &raquo; Админпанель</title>
    <link rel="stylesheet" type="text/css" href="/engine/admin/styles/auth.css">
</head>
<body>
    <div class="form" style="height:261px;">
        <div class="header">Панель управления<br>JCat Radio Engine</div>
        <form action="" method="POST">
            <div style="text-align:center;">Временно не работает</div>
            <input class="disabled" disabled placeholder="Логин" type="text" name="login">
            <input class="disabled" disabled placeholder="Пароль" type="password" name="pass">
            <button class="disabled" disabled type="submit" name="submit">Восстановить</button>
            <div class="links">
                <a href="/admin.php">Авторизация</a><br>
                <a href="/admin.php?do=reg">Регистрация</a><br>
            </div>
        </form>
    </div>
</body>
</html>