<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://radiocms.tk
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Настройки сайта
=====================================
*/
 if (! defined ('JRE_KEY')) {
    die ( "Hacking attempt!" );
 }
 include ( ENGINE_DIR . '/admin/head.html');
?>
<h1>Настройки сайта</h1>
<form action="" method="POST">
<table>
 <tbody>
    <tr>
      <td>
        <div>Название сайта:</div>
        <small>Выводится в браузере</small>
      </td>
      <td>
        <input class="input" required type="text" name="title" value="<?php echo $config['title'];?>">
      </td>
    </tr>
    <tr>
      <td>
        <div>Описание сайта:</div>
        <small>Краткое описание вашего сайта</small>
      </td>
      <td>
        <input class="input" type="text" name="description" value="<?php echo $config['description'];?>">
      </td>
    </tr>
    <tr>
      <td>
        <div>Ключевые слова:</div>
        <small>Введите через запятую основные ключевые слова для вашего сайта</small>
      </td>
      <td>
        <textarea style="height:60px;max-width:280px;" class="input" name="keywords"><?php echo $config['keywords'];?></textarea>
      </td>
    </tr>
    <tr>
      <td>
        <div>Системный E-Mail адрес администратора:</div>
        <small>Введите E-Mail адрес администратора сайта. От имени данного адреса будут отправляться служебные сообщения скрипта, например уведомления пользователей о важных новостях и т.д. А также на этот адрес будут отправляться системные уведомления для администрации сайта, например, уведомления обратной связи и т.д.</small>
      </td>
      <td>
        <input class="input" type="email" name="email" value="<?php echo $config['admin_mail'];?>">
      </td>
    </tr>
    <tr>
      <td>
        <div>Ключ защиты:</div>
        <small>Специальный ключ защиты регистрации</small>
      </td>
      <td>
        <input class="input" required type="password" name="reg_key" value="<?php echo $config['reg_key'];?>">
      </td>
    </tr>
    <tr>
      <td>
        <div>Количество новостей на странице:</div>
        <small>Количество кратких новостей, которое будет выводиться на страницу</small>
      </td>
      <td>
        <input style="padding-right:0;width:290px;" class="input" required type="number" min="0" name="news_num" value="<?php echo $config['shownews'];?>">
      </td>
    </tr>
    <tr>
      <td>
        <div>Количество программ на странице:</div>
        <small>Количество программ, которое будет выводиться на страницу</small>
      </td>
      <td>
        <input style="padding-right:0;width:290px;" class="input" required type="number" min="0" name="prog_num" value="<?php echo $config['showprog'];?>">
      </td>
    </tr>
    <tr>
      <td>
        <div>Информация выводимая по умолчанию на главной странице:</div>
        <small>Выберите тип контента, который будет выводится на главной странице сайта по умолчанию. В случае если вы выбираете показ статической страницы, вам будет выводится контент шаблона index.tpl</small>
      </td>
      <td>
        <select required style="width:302px;" class="input size="1" name="mpage">
          <option <?php if ($config['main_page'] == '1') echo 'selected'; ?> value="1">Статическая страница</option>
          <option <?php if ($config['main_page'] == '2') echo 'selected'; ?> value="2">Новости (страница "/news")</option>
        </select>
      </td>
    </tr>
  </tbody>
 </table>
 <input class="button" type="submit" value="Сохранить" name="submit">
</form>
<?php
 if(isset($_POST['submit'])){
 $write = "<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://radiocms.tk
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Конфигурационный файл
=====================================
*/
\$config = array (
'title' => '".addslashes($_POST['title'])."',
'description' => '".addslashes($_POST['description'])."',
'keywords' => '".addslashes($_POST['keywords'])."',
'admin_mail' => '".$_POST['email']."',
'shownews' => '".$_POST['news_num']."',
'showprog' => '".$_POST['prog_num']."',
'main_page' => '".$_POST['mpage']."',
'reg_key' => '".$_POST['reg_key']."',
'jre_version' => '".$config['jre_version']."'
);
?>";
  file_put_contents(ENGINE_DIR . '/data/config.php', $write);
}
 include ( ENGINE_DIR . '/admin/footer.html');
?>