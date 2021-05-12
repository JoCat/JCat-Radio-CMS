<?php

namespace JRC\Frontend\Controllers;

class MainController extends \JRC\Core\Controller
{
    public function actionIndex()
    {
        $this->render('index');
    }
}