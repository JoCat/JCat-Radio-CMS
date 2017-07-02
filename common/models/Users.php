<?php

namespace JRC\Common\Models;

/**
* 
*/
class Users extends \JRC\Core\Model
{
    static $table_name = 'users';

    public $username;
    public $usergroup;

    static $belongs_to = [['user_groups', 'class_name' => '\JRC\Common\Models\UserGroups']];
}