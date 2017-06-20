<?php

namespace JRC\Core;

/**
* 
*/
class View
{
    public $template = 'default'; //шаблон по умолчанию
    public $template_view = 'index.php'; //шаблон по умолчанию
    
    final public function render($content_view, $data = null)
    {
        if(is_array($data)) {
            extract($data);
        }
        ob_start();
        // / => DS
        include ROOT_DIR . '/template/' . $this->template . '/views/' . $content_view . '.php';
        $content = ob_get_clean();
        include ROOT_DIR . '/template/' . $this->template . '/views/' . $template_view;
    }
}