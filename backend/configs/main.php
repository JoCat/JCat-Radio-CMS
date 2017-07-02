<?php

return [
    'models_dir' => dirname(__DIR__) . '/models/',
    'views_dir' => dirname(__DIR__) . '/views/',
    'controllers_dir' => dirname(__DIR__) . '/controllers/',
    'controllers_namespace' => 'JRC\Backend\Controllers\\',
    'connect' => 'mysql://root:@127.0.0.1/jrc_db',
    'admin_mail' => 'admin@test.home',
    'base_dir' => '/admin/'
];
