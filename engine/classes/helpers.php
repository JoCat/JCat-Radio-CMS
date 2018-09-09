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
        $this->msg .= '<div class="alert '. (($error == true) ? 'alert-danger' : 'alert-success') .'" role="alert">'. $data .'</div>';
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
      global $template;
        return '<div class="error-alert">
          <p>
            <b>Внимание! Обнаружена ошибка.</b><br>
            '.$reason.'
          </p>
          <button onclick="history.go(-1);" class="btn btn-danger">Вернутся назад</button>
        </div>';
    }

    public function get_templates()
    {
      $tpl_dir = ROOT_DIR . '/template/';
      $dirs = scandir($tpl_dir);
      unset($dirs[0], $dirs[1]);
      foreach ($dirs as $value) {
        if (is_dir($tpl_dir . $value)) {
          $links[] = $value;
        }
      }
      return $links;
    }

    public function text_cut($text, $lenght)
    {
      return mb_strlen($text) > $lenght ?
        mb_substr($text, 0, $lenght) . '...' :
        $text;
    }

}
$helpers = new Helpers;
