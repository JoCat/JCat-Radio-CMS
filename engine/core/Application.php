<?php

namespace JRC\Core;

/**
* 
*/
final class Application
{

                                    /* Временно */
    public $models_dir              = ROOT_DIR . '/engine/frontend/models/';
    public $controllers_dir         = ROOT_DIR . '/engine/frontend/controllers/';
    public $controllers_namespace   = 'JRC\Frontend\Controllers\\';
    public $connect                 = 'mysql://root:@127.0.0.1/jrc_db';

    public function run()
    {
        \ActiveRecord\Config::initialize(function($cfg)
        {
            $cfg->set_model_directory($this->models_dir);
            $cfg->set_connections(['development' => $this->connect]);
        });

        \JRC\Core\Route::run(
            $this->controllers_dir,
            $this->controllers_namespace
        );
    }
}
