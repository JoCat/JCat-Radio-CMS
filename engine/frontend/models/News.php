<?php

namespace JRC\Frontend\Models;

/**
* 
*/
class News extends \JRC\Core\Model
{
    static $table_name = 'news';

    public $link;

    static $belongs_to = [['users']];
}