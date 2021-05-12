<?php

namespace JRC\Common\Models;

class News extends \JRC\Core\Model
{
    public $link;

    static $belongs_to = [['user', 'foreign_key' => 'author_id']];
}