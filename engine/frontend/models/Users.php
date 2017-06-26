<?php

namespace JRC\Frontend\Models;

/**
* 
*/
class Users extends \JRC\Core\Model
{
    static $table_name = 'users';

    public $username;
    public $usergroup;

    static $belongs_to = [['user_groups']];
}