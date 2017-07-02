<?php

namespace JRC\Frontend\Controllers;

use JRC\Common\Components\Auth;

/**
* 
*/
class AuthController extends \JRC\Core\Controller
{
    public function actionIndex()
    {
        if (!empty($_POST)) {
            (new Auth)->auth();
        } else {
            $this->render('auth');
        }
    }

    public function actionLogout()
    {
        session_destroy();
        header('Location:http://'. $_SERVER['HTTP_HOST']);
    }
}
