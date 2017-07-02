<?php

namespace JRC\Backend\Controllers;

use JRC\Common\Models\Users;
use JRC\Common\Models\News;
use JRC\Common\Models\Programs;
use JRC\Common\Models\Schedule;
use JRC\Backend\Models\VisitStats;

/**
* 
*/
class MainController extends \JRC\Core\Controller
{
    public function actionIndex()
    {
        $stats = [
            'users' => Users::count(),
            'users_active' => Users::count([
                'conditions' => [
                    '`status` =?', 1
                ]
            ]),
            'news' => News::count([
                'conditions' => [
                    '`show` =?', 1
                ]
            ]),
            'programs' => Programs::count(),
            'schedule' => Schedule::count()
        ];

        $visit_stats = VisitStats::all([
            'order' => 'id DESC',
            'limit' =>  10
        ]);

        $visit_table = VisitStats::all([
            'select' => '`date`, COUNT(`date`) AS count',
            'group' => '`date`'
        ]);

        $this->render('index', [
            'stats' => $stats,
            'visit_stats' => $visit_stats,
            'visit_table' => $visit_table
        ]);
    }
}