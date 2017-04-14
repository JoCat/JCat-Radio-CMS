<?php
/*
=======================================
 JCat Radio Engine
---------------------------------------
 *site*
---------------------------------------
 Copyright (c) 2016-2017 Molchanov A.I.
=======================================
 Главная страница
=======================================
*/

// Debug
@error_reporting(E_ALL);
@ini_set('display_errors', true);

//Release
//@error_reporting(E_ERROR);

define('JRE_KEY', true);
define('ROOT_DIR', __DIR__);
define('ENGINE_DIR', ROOT_DIR . '/engine');

require_once(ENGINE_DIR . '/engine.php');