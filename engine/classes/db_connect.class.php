<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://jcat.tk/
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Класс подключения к БД
=====================================
*/

@mysql_connect($db_config['server'],$db_config['user'],$db_config['password']) or die("Database server connection failed. Check variables in config.php");
@mysql_select_db($db_config['database']) or die("Selecting database failed. Check variable in config.php");
?>