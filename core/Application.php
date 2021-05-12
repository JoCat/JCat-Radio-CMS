<?php

namespace JRC\Core;

final class Application
{
    public $models_dir;
    public $views_dir;
    public $controllers_dir;
    public $controllers_namespace;
    public $base_dir;
    public $connect;

    function __construct($config)
    {
        foreach ($config as $key => $value) {
            $this->$key = $value;
        }
    }

    public function run()
    {
        session_start();
        \ActiveRecord\Config::initialize(function($cfg)
        {
            $cfg->set_model_directory($this->models_dir);
            $cfg->set_connections(['development' => $this->connect]);
        });

        (new \JRC\Core\Route(
            $this->controllers_dir,
            $this->controllers_namespace,
            $this->base_dir
        ));
    }
}
