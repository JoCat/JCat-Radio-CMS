<?php

namespace JRC\Frontend\Controllers;

use JRC\Frontend\Models\News;
use JRC\Core\Exceptions\NotFoundException;

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

        foreach ($news as $value) {
            $value->link = '/news/view/'. $value->id .'-'. $value->alt_name;
        }

        $this->render('news', [
            'news' => $news
        ]);
    }

    public function actionView($link)
    {
        $link = explode('-', $link, 2);
        $post = News::find($link[0] ,[
            'select' => '`news`.*, `users`.login',
            'joins' => ['users']
        ]);

        if (empty($post)) {
            throw new NotFoundException("Post not found");
        }

        $this->render('fullnews', [
            'post' => $post
        ]);
    }
}