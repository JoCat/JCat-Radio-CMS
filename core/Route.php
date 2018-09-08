<?php

namespace JRC\Core;

use JRC\Core\Exceptions\NotFoundException;

final class Route
{
    public $controller_name;
    public $action_name;
    public $routes = [];
    public $controllers_dir;
    public $controllers_namespace;
    public $base_dir;

    function __construct($controllers_dir, $controllers_namespace, $base_dir)
    {
        $this->controllers_dir = $controllers_dir;
        $this->controllers_namespace = $controllers_namespace;
        $this->base_dir = $base_dir;
        $this->controller_name = 'main';
        $this->action_name = 'index';
        $this->load();
        $this->run();
    }

    public function load()
    {
        $this->routes = require_once (
            dirname($this->controllers_dir) . '/configs/routes.php'
        );
    }

    public function run()
    {
        $route = explode('/',
            substr(
                $_SERVER['REQUEST_URI'],
                //strpos($_SERVER['REQUEST_URI'], $this->base_dir) + strlen($this->base_dir)
                strlen($this->base_dir)
            )
        );
        // Bug 1 : Fix url parse| Fixed?

        $link = implode('/', $route);

        if (!empty($path = array_shift($route))) {   
            $this->controller_name = $path;
        }
        if (!empty($path = array_shift($route))) {
            $this->action_name = $path;
        }

        // Проверяем на соответствие с шаблонами адресов
        foreach ($this->routes as $key => $value) {
            if (preg_match(
                    '/' . str_replace('/', '\/', $key) . '/',
                    '/' . $link . '/'
                )
            ) {
                $route = preg_replace(
                    '/' . str_replace('/', '\/', $key) . '/',
                    $value,
                    $link
                );
                $route = explode('/', $route);
                $this->controller_name = array_shift($route);
                $this->action_name = array_shift($route);
                break;
            }
        }

        $this->controller_name = mb_convert_case($this->controller_name, MB_CASE_TITLE).'Controller';
        $this->action_name = 'action'.mb_convert_case($this->action_name, MB_CASE_TITLE);

        if(file_exists($this->controllers_dir.$this->controller_name.'.php'))
        {
            $controller_class = $this->controllers_namespace.$this->controller_name;
            $controller = new $controller_class;
        } else {
            throw new NotFoundException("Class '$this->controller_name' not found");
        }
        
        if(method_exists($controller, $this->action_name))
        {
            call_user_func_array([$controller, $this->action_name], $route);
        } else {
            throw new NotFoundException("Action '$this->action_name' not found");
        }
    
    }
}
