<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

$config = array_merge(
    require_once __DIR__ . '/configs/main.php'
);

$app = new JRC\Core\Application($config);
$app->run();
