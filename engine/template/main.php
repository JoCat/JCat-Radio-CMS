<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://radiocms.tk
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Обработка начальной страницы
=====================================
*/
 if (! defined ('JRE_KEY')) {
    die ( "Hacking attempt!" );
 }

 if ($config['main_page'] == 1) {
 $tpl -> set( "{content}", $tpl -> showmodule( "index.tpl" ) );
 }
 if ($config['main_page'] == 2) {
 $_GET['show'] = 'shortnews';
 include( ENGINE_DIR . '/template/news.php' );
 $page_title = false;
 }
?>