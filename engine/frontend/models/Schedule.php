<?php

namespace JRC\Frontend\Models;

/**
* 
*/
class Schedule extends \JRC\Core\Model
{
    static $table_name = 'schedule';

    public $data;

    static $belongs_to = [['programs']];

    public function getDay($day)
    {
        return Schedule::all([
            'conditions' => [
                'schedule.day = ? AND schedule.show = ?', $day, 1
            ],
            'select' => '`schedule`.*, `programs`.*',
            'joins' => ['programs'],
            'order' => 'schedule.start_time ASC'
        ]);
    }
}