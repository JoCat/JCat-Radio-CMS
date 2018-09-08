<?php

namespace JRC\Backend\Controllers;

use JRC\Common\Models\News;

/**
* 
*/
class NewsController extends \JRC\Core\Controller
{
    public function actionIndex()
    {
        $news = News::all([
            'conditions' => [
                '`show` =?', 1
            ],
            'limit' => 10,
            'offset' => 0
        ]);

        $this->render('index', [
            'news' => $news
        ]);
    }
}