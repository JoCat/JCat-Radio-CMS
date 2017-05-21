<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://jcat.tk/
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Обновление CMS
=====================================
*/

@error_reporting ( E_ALL ^ E_WARNING ^ E_NOTICE );
@ini_set ( 'display_errors', true );
@ini_set ( 'html_errors', false );
@ini_set ( 'error_reporting', E_ALL ^ E_WARNING ^ E_NOTICE );

define ( 'JRE_KEY', true );
define ( 'ROOT_DIR', ".." );
define ( 'ENGINE_DIR', ROOT_DIR . '/engine' );
session_start();

$header = <<<HTML
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=620, maximum-scale=1, initial-scale=1, user-scalable=0">
  <title>JCat Radio Engine - Обновление</title>
  <style>
    body{
        margin: 0px;
        font-family: 'Cuprum', sans-serif;
        font-size: 16px;
        background-color: #fafafa;
    }
    header {
        padding: 10px;
        color: white;
        background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAQAAAAECAYAAACp8Z5+AAAAJ0lEQVQIW2NkYGD4zzDzPwNDOiMDiGYEEkAeFAAFgcLYVECVg9QBAD7NEMms+CG9AAAAAElFTkSuQmCC) repeat;
    }
    header h1 {
        margin: 0px;
        text-align: center;
        font-weight: bold;
        text-shadow: black 2px 2px 2px;
    }
    .btn {
        border: solid 1px #ccc;
        background-color: #0099ff;
        border-radius: 3px;
        height: 40px;
        color: white;
        margin-top: 10px;
    }
    .btn:hover {
        cursor: pointer;
        background-color: #00bbff;
    }
    .content {
        width: 600px;
        margin: auto;
    }
    .eula {
        height: 300px;
        border: 1px solid #aaa;
        background-color: #fff;
        padding: 5px;
        overflow: auto;
    }
  </style>
</head>
<body>
  <header>
    <h1>Мастер обновления JCat Radio Engine</h1>
  </header>
  <div class="content">
HTML;

$footer = <<<HTML
  </div>
</body>
</html>
HTML;

function alert($title, $text, $back){
global $header, $footer;
  ($back == false) ? $back = "onclick=\"history.go(-1);\"" : $back = "onclick=\"location.assign(location.origin+'/install.php');\"";
  echo $header;
echo <<<HTML
    <h2>{$title}</h2>
    <div>{$text}</div>
    <button {$back} class="btn">Продолжить</button>
HTML;
  echo $footer;
  exit();
}

if($_REQUEST['action'] == "eula") {
    if ( !$_SESSION['jre_update'] ) alert( "Ошибка", "Обновление скрипта было начато не с начала. Вернитесь на начальную страницу обновления скрипта.", true );
    echo $header;
    
echo <<<HTML
<form id="check-eula" method="get" action="">
    <input type=hidden name=action value="function_check">
    <script type="text/javascript">
      function check_eula(){
        if( document.getElementById( 'eula' ).checked == true )
        {
            return true;
        }
        else
        {
            alert( 'Вы должны принять лицензионное соглашение, прежде чем продолжите установку.' );
            return false;
        }
      };
      document.getElementById( 'check-eula' ).onsubmit = check_eula;
    </script>
  <h2>Лицензионное соглашение</h2>
  <div>
        Пожалуйста, внимательно прочитайте и примите пользовательское соглашение по использованию програмного обеспечения JCat Radio Engine.<br><br>
        <div class="eula">
            <h3>Пользовательское лицензионное соглашение на использование програмного обеспечения "JCat Radio Engine"</h3>
            <p style="color:red;">Уважаемый Пользователь! Перед началом установки, копирования либо иного использования програмного обеспечения внимательно ознакомьтесь с условиями его использования, содержащимися в настоящем Соглашении. Обновление, запуск или иное начало использования програмного обеспечения означает надлежащее заключение настоящего Соглашения и Ваше полное согласие со всеми его условиями. Если Вы не согласны безоговорочно принять условия настоящего Соглашения, Вы не имеете права устанавливать и использовать програмное обеспечение и должны удалить все его компоненты со своего компьютера.</p>
            <p>Лицензионное соглашение програмного обеспечения "JCat Radio Engine"</p>
            <p>Copyright (c) 2016 Molchanov A.I.</p>
            <p>Данная лицензия разрешает лицам, получившим копию данного программного обеспечения и сопутствующей документации (в дальнейшем именуемыми «Программное Обеспечение»), безвозмездно использовать Программное Обеспечение, включая неограниченное право на использование, копирование, изменение, слияние, публикацию, распространение, копий Программного Обеспечения, а также лицам, которым предоставляется данное Программное Обеспечение, при соблюдении следующих условий:</p>
            <p>1. Указанное выше уведомление об авторском праве и данные условия должны быть включены во все копии или значимые части данного Программного Обеспечения.</p>
            <p>2. Запрещается сублицензирование и/или продажа копий Программного Обеспечения.</p>
            <p>ДАННОЕ ПРОГРАММНОЕ ОБЕСПЕЧЕНИЕ ПРЕДОСТАВЛЯЕТСЯ «КАК ЕСТЬ», БЕЗ КАКИХ-ЛИБО ГАРАНТИЙ, ЯВНО ВЫРАЖЕННЫХ ИЛИ ПОДРАЗУМЕВАЕМЫХ, ВКЛЮЧАЯ ГАРАНТИИ ТОВАРНОЙ ПРИГОДНОСТИ, СООТВЕТСТВИЯ ПО ЕГО КОНКРЕТНОМУ НАЗНАЧЕНИЮ И ОТСУТСТВИЯ НАРУШЕНИЙ, НО НЕ ОГРАНИЧИВАЯСЬ ИМИ. НИ В КАКОМ СЛУЧАЕ АВТОРЫ ИЛИ ПРАВООБЛАДАТЕЛИ НЕ НЕСУТ ОТВЕТСТВЕННОСТИ ПО КАКИМ-ЛИБО ИСКАМ, ЗА УЩЕРБ ИЛИ ПО ИНЫМ ТРЕБОВАНИЯМ, В ТОМ ЧИСЛЕ, ПРИ ДЕЙСТВИИ КОНТРАКТА, ДЕЛИКТЕ ИЛИ ИНОЙ СИТУАЦИИ, ВОЗНИКШИМ ИЗ-ЗА ИСПОЛЬЗОВАНИЯ ПРОГРАММНОГО ОБЕСПЕЧЕНИЯ ИЛИ ИНЫХ ДЕЙСТВИЙ С ПРОГРАММНЫМ ОБЕСПЕЧЕНИЕМ.</p>
        </div>
        <br>
        <input type="checkbox" name="eula" id="eula" class="icheck">
        <label for="eula"> Я принимаю данное соглашение</label>
  </div>
  <input class="btn" type="submit" value="Продолжить">
</form>
HTML;
} elseif($_REQUEST['action'] == "function_check") {
    if ( !$_SESSION['jre_update'] ) alert( "Ошибка", "Обновление скрипта было начато не с начала. Вернитесь на начальную страницу обновления скрипта.", true );
    if ( $_REQUEST['eula'] != 'on') alert( "Ошибка", "Вы не согласились с пользовательским соглашением. Вернитесь назад для согласия с пользовательским соглашением.<br>Если Вы не согласны безоговорочно принять условия пользовательского соглашения, Вы не имеете права устанавливать и использовать програмное обеспечение и должны удалить все его компоненты со своего компьютера.", false );
    echo $header;
    
    echo <<<HTML
<form method="get" action="">
  <input type=hidden name="action" value="update">
    <h2 class="title">Проверка установленных компонентов PHP</h2>
    <table class="table table-normal table-bordered">
    <tr>
    <td>Минимальные требования скрипта</td>
    <td>Текущее значение</td>
    </tr>
HTML;

    $status = version_compare(PHP_VERSION, '5.4', '>=') ? '<font color=green><b>Да</b></font>' : '<font color=red><b>Нет</b></font>' ;

   echo "<tr>
         <td>Версия PHP 5.4 и выше</td>
         <td colspan=2>$status</td>
         </tr>";

    $status = class_exists('PDO') ? '<font color=green><b>Да</b></font>' : '<font color=red><b>Нет</b></font>';

   echo "<tr>
         <td>Поддержка PDO</td>
         <td colspan=2>$status</td>
         </tr>";

    $status = defined('PDO::MYSQL_ATTR_INIT_COMMAND') ? '<font color=green><b>Да</b></font>' : '<font color=red><b>Нет</b></font>';

   echo "<tr>
         <td>Драйвер PDO_MYSQL</td>
         <td colspan=2>$status</td>
         </tr>";

   echo "<tr>
         <td colspan=2>Если любой из этих пунктов выделен красным, то пожалуйста выполните действия для исправления положения. В случае несоблюдения минимальных требований скрипта возможна его некорректная работа в системе.</td>
         </tr>";

echo <<<HTML
    </table>
    <input class="btn" type=submit value="Продолжить">
</form>
HTML;
} elseif($_REQUEST['action'] == "update") {
    if ( !$_SESSION['jre_update'] ) alert( "Ошибка", "Обновление скрипта было начато не с начала. Вернитесь на начальную страницу обновления скрипта.", true );

    include ( ENGINE_DIR.'/data/config.php' );
    $write = "<?php
\$config = array (
'title' => '".$config['title']."',
'description' => '".$config['description']."',
'keywords' => '".$config['keywords']."',
'admin_mail' => '".$config['admin_mail']."',
'shownews' => '".$config['shownews']."',
'showprog' => '".$config['showprog']."',
'main_page' => '".$config['main_page']."',
'reg_key' => '".$config['reg_key']."',
'jre_version' => '1.2.1'
);
?>";
    file_put_contents(ENGINE_DIR . '/data/config.php', $write);

    echo $header;
    echo <<<HTML
    <h2>Обновление завершено</h2>
    <div>
    Поздравляю Вас, JCat Radio Engine был успешно обновлён.
    <br><br>
    Приятной Вам работы,<br>
    Molchanov A.I.
    </div>
    <button onclick="location.assign(location.origin);" class="btn">Продолжить</button>
HTML;
}
else {
  include ( ENGINE_DIR.'/data/config.php' );
    if (version_compare($config['jre_version'], '1.2.1', '>=')) {
        alert( "Обновление скрипта заблокировано", "Внимание, на сервере установлена последняя версия JCat Radio Engine." );
        die ();
    }
$_SESSION['jre_update'] = true;
echo $header;
echo <<<HTML
<form method="get" action="">
    <input type="hidden" name="action" value="eula">
    <h2>Мастер обновления JCat Radio Engine</h2>
    <div>
        Добро пожаловать в мастер обновления JCat Radio Engine. Данный мастер поможет Вам обновить скрипт до последней версии.<br><br>
        Прежде чем начать обновление убедитесь, что все файлы дистрибутива загружены на сервер.<br>
        Обращаем Ваше внимание на то, что JCat Radio Engine работает с ЧПУ, а для этого необходимо, чтобы был установлен модуль <b>modrewrite</b> и его использование было разрешено.<br><br>
        <font color="red">Внимание: Перед обновлением рекомендуется создать резервную копию всех файлов скрипта на сервере!</font><br><br>
        Приятной Вам работы,<br>
        Molchanov A.I.
    </div>
    <input class="btn" type=submit value="Начать обновление">
</form>
HTML;
}
echo $footer;
?>