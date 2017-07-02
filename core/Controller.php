<?php

namespace JRC\Core;

/**
* 
*/
class Controller
{
    public $template_view = 'main'; //вид по умолчанию
    
    final public function render($content_view, $data = null, $template_view = null)
    {
        global $app;
        $template_view = ($template_view !== null) ? $template_view : $this->template_view;
        if (is_array($data)) extract($data);
        
        $dir = strtolower(
            str_replace([
                    $app->controllers_namespace,
                    'Controller'
                ],
                '',
                get_called_class()
            )
        );

        ob_start();
        include rtrim($app->views_dir, '/') . '/' . $dir . '/' . $content_view . '.php';
        $content = ob_get_clean();
        include rtrim($app->views_dir, '/') . '/' . $template_view . '.php';
    }
}
