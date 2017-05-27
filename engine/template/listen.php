<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://radiocms.tk
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Обработка страницы "Слушать"
=====================================
*/
if (!defined('JRE_KEY')) die("Hacking attempt!");
$page_title = 'Слушать';
$tpl->set("{content}", $tpl->showmodule("listen.tpl"));
