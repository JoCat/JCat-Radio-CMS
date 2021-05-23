<?php
/*
=======================================
 JCat Radio CMS
---------------------------------------
 https://radio-cms.ru/
---------------------------------------
 Copyright (c) 2016-2021 Molchanov A.I.
=======================================
 Главная страница
=======================================
*/

// Debug
@error_reporting(E_ALL);
@ini_set('display_errors', true);

//Release
//@error_reporting(E_ERROR);

mb_internal_encoding("UTF-8");

define('ROOT_DIR', __DIR__);
define('ENGINE_DIR', ROOT_DIR . '/engine');

require_once(ENGINE_DIR . '/engine.php');
