<?php

namespace JRC\Common\Components;

use JRC\Common\Models\Users;

/**
* 
*/
class Auth
{

    // Login
    public $login;
    // Password
    public $password;

    function __construct()
    {
        // Start session
        session_start();
        // Add and check value
        $this->login = $this->getPostValue('login');
        $this->password = $this->getPostValue('password');
    }

    public function auth()
    {
        $userdata = $this->findUser($this->login);

        if (password_verify($this->password, $userdata->password)) {
            $_SESSION['user_data'] = [
                'username' => $userdata->login,
                'usergroup' => $userdata->name,
                'image' => $userdata->image
            ];
            header('Location:/');
            exit;
        } else {
            throw new \Exception('Неверный пароль!');
        }
    }

    public function getPostValue($value_name)
    {
        $value = htmlentities($_POST[$value_name]);
        if (empty($value)) {
            throw new \Exception('$value_name nf'); // Логин не введён
        } else {
            return $value;
        }
    }

    public function findUser($username)
    {
        $result = Users::find([
            'conditions' => [
                '`login` = ? AND `status` = 1', $username
            ],
            'select' => '`users`.*, `user_groups`.name',
            'joins' => 'JOIN `user_groups` ON users.usergroup_id = user_groups.id'
        ]);
        if (empty($result)) {
            throw new \Exception('User ' . $username . ' not found!');
        } else {
            return $result;
        }
    }
}