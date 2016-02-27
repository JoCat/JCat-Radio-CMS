<?php
  @mysql_connect($db_config['server'],$db_config['user'],$db_config['password']) or die("Database server connection failed. Check variables JLE_DBSERVER, JLE_DBUSER, JLE_DBPASSWORD in config.php");
  @mysql_select_db($db_config['database']) or die("Selecting database failed. Check variable in config.php");
?>