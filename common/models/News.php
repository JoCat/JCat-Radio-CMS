<?php

namespace JRC\Common\Models;

/**
* 
*/
class News extends \JRC\Core\Model
{
    static $table_name = 'news';

    public $link;

    static $belongs_to = [['users', 'class_name' => '\JRC\Common\Models\Users']];
}