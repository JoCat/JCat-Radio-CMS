<?php
/**
 * 
 */
class Helpers
{
    public $msg;

    /**
     * Функция добавления сообщений/ошибок на вывод
     * @param array $data
     */
    public function addMessage($data, $error = false)
    {
        $this->msg[] = '<span style="'. (($error == true) ? 'color:red;' : '') .'background-color:white;padding:2px;">'. $data .'</span><br>';
    }

    /**
     * Функция вывода сообщений/ошибок
     * @param array $data
     */
    public function showMessage()
    {
        if (!empty($this->msg)) {
            foreach($this->msg as $val)
            {
                echo $val;
            }
        }
    }

    /**
     * Простой генератор соли
     * @param string $sql
     */
    public function salt()
    {
        return substr(md5(uniqid()), -8);
    }

    /**
     * Проверка валидации email
     * @param string $email
     * return boolean
     */
    public function emailValid($email)
    {
        if (function_exists('filter_var')){
            return (filter_var($email, FILTER_VALIDATE_EMAIL)) ? true : false;
        } else {
            return (!preg_match("/^[a-z0-9_.-]+@([a-z0-9]+\.)+[a-z]{2,6}$/i", $email)) ? false : true;
        }      
    }
}
$helpers = new Helpers;