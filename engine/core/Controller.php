<?php

namespace JRC\Core;

/**
* 
*/
class Controller
{
    public $template = 'default'; //шаблон по умолчанию
    public $template_view = 'main'; //шаблон по умолчанию
    
    final public function render($content_view, $data = null)
    {
        if(is_array($data)) {
            extract($data);
        }
        ob_start();
        include ROOT_DIR . DS .'template'. DS . $this->template . DS . $content_view . '.php';
        $content = ob_get_clean();
        include ROOT_DIR . DS .'template'. DS . $this->template . DS . $this->template_view . '.php';
    }
}
