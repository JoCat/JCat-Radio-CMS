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
 if (! defined ('JRE_KEY')) {
    die ( "Hacking attempt!" );
 }
echo '<title>Восстановление пароля &raquo; Админпанель</title>
    <link rel="stylesheet" type="text/css" href="/engine/admin/styles/auth.css">
    <div class="form" style="height:261px;">
        <div class="header">Панель управления<br>JCat Radio Engine</div>
        <form action="" method="POST">
        <div style="text-align:center;">Временно не работает</div>
        <input class="input disabled" disabled placeholder="Логин" type="text" size="30" name="login">
        <input class="input disabled" disabled placeholder="Пароль" type="password" size="30" maxlength="20" name="pass">
        <input class="button disabled" disabled type="submit" value="Войти" name="submit">
        <div style="float:left;margin:3px 10px;">
            <a class="lostpassword" href="/admin.php">Авторизация</a><br>
            <a class="lostpassword" href="/admin.php?do=reg">Регистрация</a><br>
        </div>
        <div style="clear:both;"></div>
    </div>';
?>