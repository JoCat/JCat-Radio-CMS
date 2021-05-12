<?php

namespace JRC\Common\Models;

class Schedule extends \JRC\Core\Model
{
    public $data;

    static $belongs_to = ['program'];

    public static function getDay($day)
    {
        return Schedule::all([
            'conditions' => [
                '`schedules`.`day` = ? AND `schedules`.`show` = ?', $day, 1
            ],
            'select' => '`schedules`.*, `programs`.*',
            'joins' => ['program'],
            'order' => 'schedules.start_time ASC'
        ]);
    }
}