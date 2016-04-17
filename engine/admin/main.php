<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://jcat.tk/
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Админпанель
=====================================
*/
 if (! defined ('JRE_KEY')) {
    die ( "Hacking attempt!" );
 }
 include ( ENGINE_DIR . '/admin/head.html');
 echo '<div style="padding:5%;text-align:center;font-size:16px;">Добро пожаловать в панель управления JCat Radio Engine</div>';
 include ( ENGINE_DIR . '/admin/footer.html');
?>