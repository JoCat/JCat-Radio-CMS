<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://radiocms.tk
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Админпанель сайта
=====================================
*/

/* Debug */
@error_reporting (E_ALL);
@ini_set ('display_errors', true);
// @error_reporting ( E_ALL ^ E_WARNING ^ E_NOTICE );

define ( 'JRE_KEY', true );
define ( 'ROOT_DIR', dirname ( __FILE__ ) );
define ( 'ENGINE_DIR', ROOT_DIR . '/engine' );

require_once ( ENGINE_DIR . '/admin.php' );
?>