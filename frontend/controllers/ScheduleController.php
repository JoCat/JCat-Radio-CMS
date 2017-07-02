<?php

namespace JRC\Frontend\Controllers;

use JRC\Common\Models\Schedule;
/**
* 
*/
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
        $schedule = Schedule::all([
            'conditions' => [
                '`show` =?', 1
            ],
            'select' => 'day',
            'group' => 'day',
        ]);

        foreach ($schedule as $value) {
            $value->data = (new Schedule)->getDay($value->day);
            $value->day = $this->days[$value->day];
        }

        $this->render('schedule', [
            'schedule' => $schedule,
        ]);

    }
}