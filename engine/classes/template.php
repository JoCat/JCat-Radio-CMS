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
    private $vars = array();
    public $template;

    function set($name, $value)
    {
        $this->vars[$name] = $value;
    }

    function showmodule($tmp)
    {
        $tpl = $this->template ."/". $tmp;
        if (!file_exists($tpl)) die("Template module ". $tpl ." not found!");
        $tpl = file_get_contents($tpl);
        if (count($this->vars) > 0)
            foreach($this->vars as $name => $value)
                $tpl = str_replace($name, $value, $tpl);
        return $tpl;
    }

    function showtemplate($tplt)
    {
        $tpl = $this->template . $tplt;
        if (!file_exists($tpl)) die("Template ". $tpl ." not found!");
        $tpl = file_get_contents($tpl);
        if (count($this->vars) > 0)
            foreach($this->vars as $name => $value)
                $tpl = str_replace($name, $value, $tpl);
        echo $tpl;
    }
}
$tpl = new Template;
