<?php
/*
=======================================
 JCat Radio Engine
---------------------------------------
 *site*
---------------------------------------
 Copyright (c) 2016-2017 Molchanov A.I.
=======================================
 Админпанель
=======================================
*/
if (!defined('JRE_KEY')) die ("Hacking attempt!");
$menu->set_sidebar_menu([
    [
        'name' => 'Главная',
        'link' => '',
        'active' => true,
    ],
    [
        'name' => 'Новости',
        'link' => '?do=news',
    ],
    [
        'name' => 'Программы',
        'link' => '?do=programs',
    ],
    [
        'name' => 'Расписание',
        'link' => '?do=schedule',
    ],
    [
        'name' => 'Статические страницы',
        'link' => '?do=static',
    ],
], 'admin.php');
?>
<h2 class="tac">Добро пожаловать в панель управления JCat Radio Engine</h2>
