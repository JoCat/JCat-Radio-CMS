<?php

namespace JRC\Frontend\Controllers;

use JRC\Common\Components\Reg;

class RegController extends \JRC\Core\Controller
{
    
    public function actionIndex()
    {
        if (!empty($_POST)) {
            (new Reg)->reg();
        } else {
            $this->render('index');
        }
    }

    public function actionActivate($key)
    {
        if (!empty($key)) {
            Reg::activate($key);
            $this->render('static', [
                'content' => '<div class="alert alert-success">Ваш аккаунт успешно активирован!</div>'
            ]);
        } else {
            throw new \Exception('Не указан ключ активации аккаунта.');
        }
    }
}
