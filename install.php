<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://jcat.tk/
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Установка CMS
=====================================
*/

@error_reporting ( E_ALL ^ E_WARNING ^ E_NOTICE );
@ini_set ( 'display_errors', true );
@ini_set ( 'html_errors', false );
@ini_set ( 'error_reporting', E_ALL ^ E_WARNING ^ E_NOTICE );

define ( 'JRE_KEY', true );
define ( 'ROOT_DIR', dirname ( __FILE__ ) );
define ( 'ENGINE_DIR', ROOT_DIR . '/engine' );
session_start();

$header = <<<HTML
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=620, maximum-scale=1, initial-scale=1, user-scalable=0">
  <title>JCat Radio Engine - Установка</title>
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
    <h1>Мастер установки JCat Radio Engine</h1>
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
    if ( !$_SESSION['jre_install'] ) alert( "Ошибка", "Установка скрипта была начата не с начала. Вернитесь на начальную страницу установки скрипта.", true );
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
            <p style="color:red;">Уважаемый Пользователь! Перед началом установки, копирования либо иного использования програмного обеспечения внимательно ознакомьтесь с условиями его использования, содержащимися в настоящем Соглашении. Установка, запуск или иное начало использования програмного обеспечения означает надлежащее заключение настоящего Соглашения и Ваше полное согласие со всеми его условиями. Если Вы не согласны безоговорочно принять условия настоящего Соглашения, Вы не имеете права устанавливать и использовать програмное обеспечение и должны удалить все его компоненты со своего компьютера.</p>
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
    if ( !$_SESSION['jre_install'] ) alert( "Ошибка", "Установка скрипта была начата не с начала. Вернитесь на начальную страницу установки скрипта.", true );
    if ( $_REQUEST['eula'] != 'on') alert( "Ошибка", "Вы не согласились с пользовательским соглашением. Вернитесь назад для согласия с пользовательским соглашением.<br>Если Вы не согласны безоговорочно принять условия пользовательского соглашения, Вы не имеете права устанавливать и использовать програмное обеспечение и должны удалить все его компоненты со своего компьютера.", false );
    echo $header;
    
    echo <<<HTML
<form method="get" action="">
  <input type=hidden name="action" value="config">
    <h2 class="title">Проверка установленных компонентов PHP</h2>
    <table class="table table-normal table-bordered">
    <tr>
    <td>Минимальные требования скрипта</td>
    <td>Текущее значение</td>
    </tr>
HTML;
    
    $status = phpversion() < '5.3' ? '<font color=red><b>Нет</b></font>' : '<font color=green><b>Да</b></font>';

   echo "<tr>
         <td>Версия PHP 5.3 и выше</td>
         <td colspan=2>$status</td>
         </tr>";

    $status = class_exists('PDO') ? '<font color=green><b>Да</b></font>' : '<font color=red><b>Нет</b></font>';

   echo "<tr>
         <td>Поддержка PDO</td>
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
} elseif($_REQUEST['action'] == "config") {
    if ( !$_SESSION['jre_install'] ) alert( "Ошибка", "Установка скрипта была начата не с начала. Вернитесь на начальную страницу установки скрипта.", true );
    echo $header;
    
    echo <<<HTML
<script type="text/javascript">
with (document)
upp = new Array('','A','B','C','D','E','F','G','H','I','J','K','L',
    'M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
low = new Array('','a','b','c','d','e','f','g','h','i','j','k','l',
    'm','n','o','p','q','r','s','t','u','v','w','x','y','z');
dig = new Array('','0','1','2','3','4','5','6','7','8','9');

function rnd(x,y,z) {
 var num;
 do {
    num = parseInt(Math.random()*z);
    if (num >= x && num <= y) break;
 } while (true);
return(num);
}
function gen_pass() {
var pswrd = '';
var znak, s;
var k = 0;
var n = 16;
var pass = new Array();
var w = rnd(30,80,100);
for (var r = 0; r < w; r++) {
    znak = rnd(1,26,100); pass[k] = upp[znak]; k++;
    znak = rnd(1,26,100); pass[k] = low[znak]; k++;
    znak = rnd(1,10,100); pass[k] = dig[znak]; k++;
}
for (var i = 0; i < n; i++) {
    s = rnd(1,k-1,100);
    pswrd += pass[s];
}
document.form.reg_key.value = pswrd;
}
</script>
<form method="post" action="" name="form">
<input type=hidden name="action" value="install">
    <h2>Настройка конфигурации системы</h2>
    <table width="100%">
HTML;
    
echo '<tr><td colspan="2"><b>Данные для доступа к MySQL серверу</b></td></tr>
<tr><td style="padding: 5px;">Сервер MySQL:<td style="padding: 5px;"><input required type=text size="28" name="dbhost" value="localhost"></tr>
<tr><td style="padding: 5px;">Имя базы данных:<td style="padding: 5px;"><input required type=text size="28" name="dbname"></tr>
<tr><td style="padding: 5px;">Имя пользователя:<td style="padding: 5px;"><input required type=text size="28" name="dbuser"></tr>
<tr><td style="padding: 5px;">Пароль:<td style="padding: 5px;"><input required type=password size="28" name="dbpasswd"></tr>
<tr><td colspan="2"><b>Данные для доступа к панели управления</b></td></tr>
<tr><td style="padding: 5px;">Имя администратора:<td style="padding: 5px;"><input required type=text size="28" name="reg_username" ></tr>
<tr><td style="padding: 5px;">Пароль:<td style="padding: 5px;"><input required type=password size="28" name="reg_password1"></tr>
<tr><td style="padding: 5px;">Повторите пароль:<td style="padding: 5px;"><input required type=password size="28" name="reg_password2"></tr>
<tr><td style="padding: 5px;">E-mail:<td style="padding: 5px;"><input required type=text size="28" name="reg_email"></tr>
<tr><td colspan="2"><b>Дополнительные настройки</b></td></tr>
<tr><td style="padding: 5px;">Ключ защиты регистрации:<td style="padding: 5px;"><input required type=text size="28" name="reg_key" ><input class="btn" style="height:21px;margin:0;" type="button" value="Сгенерировать" onClick=gen_pass()></tr>';

echo <<<HTML
    </table>
    <input class="btn" type=submit value="Продолжить">
</form>
HTML;
} elseif($_REQUEST['action'] == "install")
{
    if ( !$_SESSION['jre_install'] ) alert( "Ошибка", "Установка скрипта была начата не с начала. Вернитесь на начальную страницу установки скрипта.", true );
    if(!$_POST['reg_username'] or !$_POST['reg_email'] or !$_POST['reg_password1'] or !$_POST['reg_password2'] or !$_POST['dbhost'] or !$_POST['dbname'] or !$_POST['dbuser'] or !$_POST['dbpasswd'] or !$_POST['reg_key']){ alert("Ошибка!!!" ,"Заполните необходимые поля!", false); }
    if($_POST['reg_password1'] != $_POST['reg_password2']) { alert("Ошибка!!!" ,"Введённые пароли не совпадают!", false); }
	if (preg_match("/[\||\'|\<|\>|\[|\]|\"|\!|\?|\$|\@|\#|\/|\\\|\&\~\*\{\+]/", $_POST['reg_username']))
	{
		alert("Ошибка!!!" ,"Введенное имя администратора недопустимо к регистрации!", false);
	}
    include( ENGINE_DIR . '/classes/auth_functions.php' );
    //Получаем ХЕШ соли
    $salt = salt();
    //Солим пароль
    $reg_password = md5(md5($_POST['reg_password1']).$salt);
    $config = "<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://jcat.tk/
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Конфигурационный файл
=====================================
*/
\$config = array (
'title' => 'JRE Template - JCat Radio Engine',
'description' => 'Test site for JRE',
'keywords' => 'JRE, Default Template, Radio Engine',
'admin_mail' => '".$_POST['reg_email']."',
'shownews' => '5',
'showprog' => '5',
'main_page' => '1',
'reg_key' => '".$_POST['reg_key']."',
'jre_version' => '1.0'
);
?>";

    $db_config = "<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://jcat.tk/
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Конфигурационный файл базы данных
=====================================
*/
\$db_config = array (
'host' => '".$_POST['dbhost']."',
'user' => '".$_POST['dbuser']."',
'password' => '".$_POST['dbpasswd']."',
'database' => '".$_POST['dbname']."'
);
?>";
    mkdir(ENGINE_DIR . '/data', 0644);
    $src = fopen(ENGINE_DIR . '/data/config.php', 'w');
    fwrite($src, $config);
    fclose($src);
    @chmod(ENGINE_DIR . '/data/config.php', 0644);
    
    $src = fopen(ENGINE_DIR . '/data/db_config.php', 'w');
    fwrite($src, $db_config);
    fclose($src);
    @chmod(ENGINE_DIR . '/data/db_config.php', 0644);
    
    $table = array();

    $table[] = "DROP TABLE IF EXISTS `jre_news`";
    $table[] = "CREATE TABLE IF NOT EXISTS `jre_news` (
      `id` int NOT NULL AUTO_INCREMENT,
      `date` int NOT NULL DEFAULT '0',
      `title` varchar(255) NOT NULL,
      `news` text NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

    $table[] = "DROP TABLE IF EXISTS `jre_rj`";
    $table[] = "CREATE TABLE IF NOT EXISTS `jre_rj` (
      `id` int NOT NULL AUTO_INCREMENT,
      `name` varchar(255) NOT NULL,
      `description` text NOT NULL,
      `pic` varchar(64) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

    $table[] = "DROP TABLE IF EXISTS `jre_programs`";
    $table[] = "CREATE TABLE IF NOT EXISTS `jre_programs` (
      `id` int NOT NULL AUTO_INCREMENT,
      `title` varchar(255) NOT NULL,
      `pic` varchar(64) NOT NULL,
      `info` text NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

    $table[] = "DROP TABLE IF EXISTS `jre_schedule`";
    $table[] = "CREATE TABLE IF NOT EXISTS `jre_schedule` (
      `id` int NOT NULL AUTO_INCREMENT,
      `day` varchar(9) NOT NULL,
      `title` varchar(255) NOT NULL,
      `time` int(5) NOT NULL DEFAULT '0',
      `endtime` int(5) NOT NULL DEFAULT '0',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

    $table[] = "DROP TABLE IF EXISTS `jre_users`";
    $table[] = "CREATE TABLE IF NOT EXISTS `jre_users` (
      `id` int NOT NULL AUTO_INCREMENT,
      `login` varchar(64) NOT NULL,
      `pass` varchar(32) NOT NULL,
      `email` varchar(128) NOT NULL,
      `salt` varchar(32) NOT NULL,
      `active_hex` varchar(32) NOT NULL,
      `status` int(1) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

    $table[] = "DROP TABLE IF EXISTS `jre_static`";
    $table[] = "CREATE TABLE IF NOT EXISTS `jre_static` (
      `id` int NOT NULL AUTO_INCREMENT,
      `link` varchar(255) NOT NULL,
      `title` varchar(255) NOT NULL,
      `content` text NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

    include( ENGINE_DIR . '/data/db_config.php' );
    include( ENGINE_DIR . '/classes/db_connect.php' );

    foreach($table as $value) {
        $pdo->query($value);
    }
    unset($value);

    $sql = 'INSERT INTO `jre_users` VALUES( "", :login, :pass, :email, :salt, "'. md5($salt) .'", 1)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':login', $_POST['reg_username'], PDO::PARAM_STR);
    $stmt->bindValue(':email', $_POST['reg_email'], PDO::PARAM_STR);
    $stmt->bindValue(':pass', $reg_password, PDO::PARAM_STR);
    $stmt->bindValue(':salt', $salt, PDO::PARAM_STR);
    $stmt->execute();

    echo $header;
    echo <<<HTML
    <h2>Установка завершена</h2>
    <div>
    Поздравляю Вас, JCat Radio Engine был успешно установлен на Ваш сервер. Теперь Вы можете зайти на главную <a href="index.php">страницу вашего сайта</a>  и посмотреть возможности скрипта.
    Также Вы можете <a href="admin.php">зайти в панель управления</a> JCat Radio Engine и изменить другие настройки системы, добавить парочку новостей, программ, ведущих и т.д.
    <br><br>
    <font color="red">Внимание: при установке скрипта создается структура базы данных, создается аккаунт администратора, а также прописываются основные настройки системы, поэтому после успешной установки удалите файл <b>install.php</b> во избежание повторной установки скрипта!</font>
    <br><br>
    Приятной Вам работы,<br>
    Molchanov A.I.
    </div>
    <button onclick="location.assign(location.origin);" class="btn">Продолжить</button>
HTML;
}
else {
	if (@file_exists(ENGINE_DIR.'/data/config.php')) {
		alert( "Установка скрипта заблокирована", "Внимание, на сервере обнаружена уже установленная копия JCat Radio Engine. Если Вы хотите еще раз произвести установку скрипта, то Вам необходимо вручную удалить файл <b>/engine/data/config.php</b>, используя FTP протокол." );
		die ();
	}
$_SESSION['jre_install'] = true;
echo $header;
echo <<<HTML
<form method="get" action="">
    <input type="hidden" name="action" value="eula">
    <h2>Мастер установки JCat Radio Engine</h2>
    <div>
        Добро пожаловать в мастер установки JCat Radio Engine. Данный мастер поможет Вам установить скрипт всего за пару минут. Однако, не смотря на это, мы настоятельно рекомендуем Вам ознакомиться с документацией по работе со скриптом, а также по его установке, которая поставляется вместе со скриптом.<br><br>
        Прежде чем начать установку убедитесь, что все файлы дистрибутива загружены на сервер.<br>
        Обращаем Ваше внимание на то, что JCat Radio Engine работает с ЧПУ, а для этого необходимо, чтобы был установлен модуль <b>modrewrite</b> и его использование было разрешено.<br><br>
        <font color="red">Внимание: при установке скрипта создается структура базы данных, создается аккаунт администратора, а также прописываются основные настройки системы, поэтому после успешной установки удалите файл <b>install.php</b> во избежание повторной установки скрипта!</font><br><br>
        Приятной Вам работы,<br>
        Molchanov A.I.
    </div>
    <input class="btn" type=submit value="Начать установку">
</form>
HTML;
}
echo $footer;
?>