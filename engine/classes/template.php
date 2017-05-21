<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://radiocms.tk
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Класс шаблонизатора
=====================================
*/
if (!defined('JRE_KEY')) die("Hacking attempt!");
class Template
{
    private $vars = [];
    public $template;

    public function __construct($tpl_dir)
    {
        $this->template = ROOT_DIR . "/template/$tpl_dir";
    }

    public function set($name, $value)
    {
        $this->vars[$name] = $value;
    }

    public function show($tmp)
    {
        $tpl = $this->template . "/$tmp.tpl";
        if (!file_exists($tpl)) die("Template $tpl not found!");
        $tpl = file_get_contents($tpl);
        if (count($this->vars) > 0) {
            foreach($this->vars as $name => $value) {
                $tpl = str_replace($name, $value, $tpl);
            }
        }
        return $tpl;
    }

    public function showtemplate()
    {
        die($this->show('main'));
    }
}
