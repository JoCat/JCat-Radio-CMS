<?php

class ErrorHandler
{
    const ERROR_404_RU = 'Ошибка 404';
    const ERROR_404_EN = 'Error 404';

    const ERROR_404_RU_TEXT = 'Страница не найдена';
    const ERROR_404_EN_TEXT = 'Not Found';

    const ERROR_404_HEADER = 'HTTP/1.1 404 Not Found';

    public static function error_notFound($lang = 'ru')
    {
        return self::get_template(
            ($lang == 'ru') ? self::ERROR_404_RU : self::ERROR_404_EN,
            ($lang == 'ru') ? self::ERROR_404_RU_TEXT : self::ERROR_404_EN_TEXT,
            self::ERROR_404_HEADER,
            $lang
        );
    }

    public static function get_template($err_num, $err_text, $header, $lang)
    {
        header($header);
        die('<!DOCTYPE html>
<html lang="' . $lang . '">
  <head>
    <meta charset="UTF-8">
    <title>' . $err_num . ' : ' . $err_text . '</title>
  </head>
  <body>
    <div>
      <h1>' . $err_num . '</h1>
      <h2>' . $err_text . '</h2>
    </div>
    <hr>
    <footer>
      Powered by: JCat Radio Engine v.1.3_dev
    </footer>
  </body>
</html>');
    }
}
