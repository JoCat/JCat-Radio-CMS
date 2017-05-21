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
        $this->msg .= '<span style="'. (($error == true) ? 'color:red;' : '') .'background-color:white;padding:2px;">'. $data .'</span><br>';
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

    public function get_date($date)
    {
        $timestamp = strtotime($date);
        if (date('dmy', $timestamp) == date('dmy')) {
            return 'Сегодня в ' . date('H:i', $timestamp);
        } elseif (date('dmy', $timestamp) == date('dmy', time()-86400)) {
            return 'Вчера в ' . date('H:i', $timestamp);
        } else {
            return date('d/m/Y - H:i', $timestamp);
        }
    }

    public function get_time($time)
    {
        return date('H:i', strtotime($time));
    }

    /**
     * Функция вывода сообщений об ошибке
     * @param  string  $reason  Причина ошибки
     */
    public function get_error($reason)
    {
        return '<div class="error-alert">
          <p>
            <b>Внимание! Обнаружена ошибка.</b><br>
            '.$reason.'
          </p>
          <button onclick="history.go(-1);" class="btn btn-danger">Вернутся назад</button>
        </div>';
    }
}
$helpers = new Helpers;
