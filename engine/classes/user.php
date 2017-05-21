<?php
/**
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
}
$user = new User;
