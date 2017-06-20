<?php

require_once ROOT_DIR . '/vendor/autoload.php';

// Подгружать конфиг из других файлов
//$config = ["require"];

$app = new JRC\Core\Application($config);
$app->run();
