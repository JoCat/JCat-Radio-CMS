<?php

namespace JRC\Frontend\Controllers;

/**
* 
*/
class MainController extends \JRC\Core\Controller
{
    public function actionIndex()
    {
        echo "Hello World";
    }

    public function actionView($name)
    {
        echo "Hello $name";
    }
}