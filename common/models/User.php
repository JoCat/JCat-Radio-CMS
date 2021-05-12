<?php

namespace JRC\Common\Models;

class User extends \JRC\Core\Model
{
    static $belongs_to = ['users_group'];
}