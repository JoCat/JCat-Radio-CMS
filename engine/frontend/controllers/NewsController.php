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
                '`show` =?', 0
            ],
            'limit' => 10,
            'offset' => 0
        ]);

        $this->render('news', [
            'news' => $news
        ]);
    }

    public function actionView($link)
    {
        $link = explode('-', $link, 2);
        $post = News::find($link[0], [
            'conditions' => [
                'alt_name = ?', $link[1]
            ],
            'joins' => 'JOIN `users` ON news.author_id = users.id'
        ]);

        if (empty($post)) {
            throw new NotFoundException("Post not found");
        }

        $this->render('fullnews', [
            'post' => $post
        ]);
    }
}