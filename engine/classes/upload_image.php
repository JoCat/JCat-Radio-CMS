<?php
/**
* 
*/
class UploadImage
{
    public $uploadDir;
    public $errorCode;
    public $filePath;

    function __construct()
    {
        $this->uploadDir = ROOT_DIR . '/uploads/images/';
    }

    // Проверим на ошибки
    private function checkError()
    {
        if ($this->errorCode !== UPLOAD_ERR_OK || !is_uploaded_file($this->filePath)) {
            // Массив с названиями ошибок
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE   => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
                UPLOAD_ERR_FORM_SIZE  => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
                UPLOAD_ERR_PARTIAL    => 'Загружаемый файл был получен только частично.',
                UPLOAD_ERR_NO_FILE    => 'Файл не был загружен.',
                UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
                UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
                UPLOAD_ERR_EXTENSION  => 'PHP-расширение остановило загрузку файла.',
            ];
            // Зададим неизвестную ошибку
            $unknownMessage = 'При загрузке файла произошла неизвестная ошибка.';
            // Если в массиве нет кода ошибки, скажем, что ошибка неизвестна
            $outputMessage = isset($errorMessages[$this->errorCode]) ? $errorMessages[$this->errorCode] : $unknownMessage;
            // Выведем название ошибки
            return $outputMessage;
        } else {
            return false;
        }
    }

    public function imageLoad($file, $dir, $filename)
    {
        $this->filePath  = $file['tmp_name'];
        $this->errorCode = $file['error'];

        if (($message = $this->checkError()) !== false) {
            return $message;
        }

        $blacklist = ['.php', '.phtml', '.php3', '.php4', '.php5', '.php7'];
        foreach ($blacklist as $item) {
            if(preg_match("/$item\$/i", $file['name'])) {
                return "Загруженный файл не является изображением";
            }
        }

        $ext = $this->getExt($file['name']);
        $whitelist = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($ext, $whitelist)) {
            return "Загруженный файл не является изображением";
        }

        $uploadfile = $this->uploadDir . $dir . '/' . $filename . '.' . $ext;
        if (!move_uploaded_file($this->filePath, $uploadfile)) {
            return "При сохранении изображения произошла ошибка";
        }
    }

    public function getExt($name)
    {
        // разбиваем имя файла по точке и получаем массив
        $filename = explode('.', $name);
        // нас интересует последний элемент массива - расширение
        return strtolower(end($filename));
    }

    public function imageDelete($dir, $name)
    {
        unlink($this->uploadDir . $dir . '/' . $name);
    }
}