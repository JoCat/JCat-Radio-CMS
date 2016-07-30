<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://jcat.tk/
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Вывод статических страниц
=====================================
*/
 if (! defined ('JRE_KEY')) {
    die ( "Hacking attempt!" );
 }

 include( ENGINE_DIR . '/data/db_config.php' );
 include( ENGINE_DIR . '/classes/db_connect.php' );

 //Выполняем запрос к БД с последующим выводом страницы
 $stmt = $pdo->prepare('SELECT * FROM jre_static WHERE link = :link');
 $stmt->execute(array('link' => $_GET['link']));
 $row = $stmt->fetch();
 $page_title = $row["title"];
 $tpl -> set( "{page}", $row["content"] );
 $tpl -> set( "{content}", $tpl -> showmodule( "static.tpl" ) );
 if (empty($row)){
    include(ROOT_DIR .'/modules/errors/404.php');
    exit;
 }
 ?>