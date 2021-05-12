<?php

namespace JRC\Frontend\Controllers;

use JRC\Common\Models\Schedule;

class ScheduleController extends \JRC\Core\Controller
{
    public $days = [
        'monday' => 'Понедельник',
        'tuesday' => 'Вторник',
        'wednesday' => 'Среда',
        'thursday' => 'Четверг',
        'friday' => 'Пятница',
        'saturday' => 'Суббота',
        'sunday' => 'Воскресенье'
    ];

    public function actionIndex()
    {
        $schedule = Schedule::find_all_by_show(1, [
            'select' => 'day',
            'group' => 'day',
        ]);

        foreach ($schedule as $value) {
            $value->data = Schedule::getDay($value->day);
            $value->day = $this->days[$value->day];
        }

        $this->render('index', compact('schedule'));

    }
}