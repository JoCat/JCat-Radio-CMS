<?php

namespace JRC\Core;

use JRC\Core\Exceptions\NotFoundException;

class Route
{
    static public function run($controllers_path, $controllers_namespace)
    {
        $controller_name = 'main';
        $action_name = 'index';
        
        $routes = explode('/', $_SERVER['REQUEST_URI']);
        array_shift($routes);

        if (!empty($route = array_shift($routes)))
        {   
            $controller_name = $route;
        }
        
        if (!empty($route = array_shift($routes)))
        {
            $action_name = $route;
        }

        $controller_name = mb_convert_case($controller_name, MB_CASE_TITLE).'Controller';
        $action_name = 'action'.mb_convert_case($action_name, MB_CASE_TITLE);

        if(file_exists($controllers_path.$controller_name.'.php'))
        {
            $controller_class = $controllers_namespace.$controller_name;
            $controller = new $controller_class;
        } else {
            throw new NotFoundException("Class '$controller_name' not found");
        }
        
        if(method_exists($controller, $action_name))
        {
            /* NEW */
            call_user_func_array([$controller, $action_name], $routes);
            /* OLD */
            //$controller->$action_name();
        } else {
            throw new NotFoundException("Action '$action_name' not found");
        }
    
    }
}
