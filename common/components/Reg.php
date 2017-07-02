<?php

namespace JRC\Common\Components;

use JRC\Common\Models\Users;

/**
* 
*/
class Reg
{
    // Login
    public $login;
    // Password
    public $password;
    // Reset password
    public $r_password;
    // Email
    public $email;
    // Reg activate key
    public $key;

    function __construct()
    {
        // Start session
        session_start();
        // Add and check value
        $this->login = $this->getPostValue('login');
        $this->password = $this->getPostValue('password');
        $this->r_password = $this->getPostValue('r_password');
        $this->email = $this->getPostValue('email');
        $this->key = $this->keyGenerate();
    }

    public static function activate($key)
    {
        $result = Users::find([
            'conditions' => [
                '`active_hex` = ?', $key
            ]
        ]);
        if (empty($result)) {
            throw new \Exception('Ключ активации не верен!');
        } else {
            $user = Users::find([
                'conditions' => [
                    '`login` = ?', $result->login
                ]
            ]);
            $user->status = 1;
            $user->save();
            header('Refresh:2; URL=/auth');
        }
    }

    public function reg()
    {
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) throw new \Exception('Не правильно введен E-mail.');
        if (!preg_match("/\w*/", $this->login)) throw new \Exception('Логин может состоять только из русских и/или латинских букв, цифр, знака подчеркивания.');
        if ($this->password != $this->r_password) throw new \Exception('Пароли не совпадают!');
        $this->loginCheck();
        $this->emailCheck();

        $user = new Users();
        $user->login = $this->login;
        $user->password = password_hash($this->password, PASSWORD_DEFAULT);
        $user->email = $this->email;
        $user->active_hex = $this->key;
        $user->status = 0;
        $user->usergroup_id = 1;
        $user->save();
        header('Location:/auth');
        $this->mailSend($this->key);
        exit;
    }

    public function getPostValue($value_name)
    {
        $value = htmlentities($_POST[$value_name]);
        if (empty($value)) {
            throw new \Exception($value_name.' not found'); // Логин не введён
        } else {
            return $value;
        }
    }

    public function keyGenerate()
    {
        return md5($this->login . time());
    }

    public function loginCheck()
    {
        if ($this->check('login', $this->login) === false) {
            throw new \Exception('Пользователь с логином: <b>'. $this->login .'</b> уже зарегестрирован!');
        }
    }

    public function emailCheck()
    {
        if ($this->check('email', $this->email) === false) {
            throw new \Exception('Пользователь с почтой: <b>'. $this->email .'</b> уже зарегестрирован!');
        }
    }

    public function check($value_name, $value)
    {
        $result = Users::find([
            'conditions' => [
                $value_name.' = ?', $value
            ]
        ]);
        if (empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    public function mailSend($key)
    {
        //Отправляем письмо для активации
        $url = 'http://'. $_SERVER['HTTP_HOST'] .'/reg/activate/'. $key;
        $message = <<<MSG
<html>
<head>
<meta charset="utf-8">
<title>Регистрация на сайте {$_SERVER['HTTP_HOST']}</title>
<style>
body {
    margin: 0;
    font-family: sans-serif;
}
h1 {
    margin: 0;
    padding: 0.5em;
    font-size: 1.5em;
    color: #fff;
    text-align: center;
    background-color: #00bbff;
}
h2 {
    font-size: 1.2em;
}
.wrap {
    margin: 10px 5px;
}
</style>
</head>
<body>
<h1>Регистрация на сайте {$_SERVER['HTTP_HOST']}</h1>
<div class="wrap">
<h2>Для активации Вашего аккаунта пройдите по ссылке: </h2>
<a href="$url">Активация аккаунта</a>
<p>Вы получили это письмо, так как этот e-mail адрес был использован при регистрации на сайте. Если Вы не регистрировались на этом сайте, просто проигнорируйте это письмо и удалите его.<br>
Данное сообщение создано автоматически, отвечать на него не нужно.</p>
</div>
</body>
</html>
MSG;
        //Формируем заголовки для почтового сервера
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
        $headers .= "From: ". '777andrey3d@rambler.ru' /*$config->admin_mail*/ ."\r\n";

        //Отправляем данные на почту
        mail($_POST['email'],
            '=?utf-8?B?' . base64_encode('Регистрация на сайте ' . $_SERVER['HTTP_HOST']) . '?=',
            $message,
            $headers
        );
    }
}
