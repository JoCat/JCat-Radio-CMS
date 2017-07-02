<?php

namespace JRC\Common\Components;

/*
*
*/
class User
{
    public $user_data;
    
    public function __construct()
    {
        if ($this->is_user_authed()) {
            $this->user_data = $_SESSION['user_data'];
        }
    }

    public function is_user_authed() {
        return isset($_SESSION['user_data']) ? true : false;
    }

    public function get($value) {
        return $this->user_data[$value];
    }

    public function get_avatar() {
        //global $config;
        return empty($this->user_data['image']) ?
            '/images/no_avatar.png' :
            '/uploads/images/users/' . $this->user_data["image"];
    }
}