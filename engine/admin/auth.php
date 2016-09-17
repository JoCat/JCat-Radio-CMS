<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://radiocms.tk
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Авторизация пользователя
=====================================
*/
 if (! defined ('JRE_KEY')) {
    die ( "Hacking attempt!" );
 }
 include( ENGINE_DIR . '/data/db_config.php' );
 include( ENGINE_DIR . '/classes/db_connect.php' );
 include( ENGINE_DIR . '/classes/auth_functions.php' );
 $err = array();
 
 //Если нажата кнопка то обрабатываем данные
 if(isset($_POST['submit']))
 {
	//Проверяем на пустоту
	if(empty($_POST['login']))
		$err[] = 'Не введен Логин';
	
	if(empty($_POST['pass']))
		$err[] = 'Не введен Пароль';
	
	//Проверяем наличие ошибок и выводим пользователю
	if(count($err) > 0)
		echo showErrorMessage($err);
	else
	{
		/*Создаем запрос на выборку из базы 
		данных для проверки подлиности пользователя*/
		$sql = 'SELECT * 
				FROM `jre_users`
				WHERE `login` = :login
				AND `status` = 1';
		//Подготавливаем PDO выражение для SQL запроса
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':login', $_POST['login'], PDO::PARAM_STR);
		$stmt->execute();

		//Получаем данные SQL запроса
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		//Если логин совподает, проверяем пароль
		if(count($rows) > 0)
		{
			//Получаем данные из таблицы
			if(md5(md5($_POST['pass']).$rows[0]['salt']) == $rows[0]['pass'])
			{
        $_SESSION['user'] = true;
				//Сбрасываем параметры
				header('Location:http://'. $_SERVER['HTTP_HOST'] .'/admin.php');
				exit;
			}
			else
				echo showErrorMessage('Неверный пароль!');
		}else{
			echo showErrorMessage('Логин <b>'. $_POST['login'] .'</b> не найден!');
		}
	}
 } 
?>
    <title>Авторизация &raquo; Админпанель</title>
    <link rel="stylesheet" type="text/css" href="/engine/admin/styles/auth.css">
    <div class="form" style="height:244px;">
        <div class="header">Панель управления<br>JCat Radio Engine</div>
        <form action="" method="POST">
        <input class="input" required placeholder="Логин" type="text" size="30" name="login">
        <input class="input" required placeholder="Пароль" type="password" size="30" maxlength="20" name="pass">
        <input class="button" type="submit" value="Войти" name="submit">
        <div style="float:left;margin:3px 10px;">
            <a class="lostpassword" href="/admin.php?do=reg">Регистрация</a><br>
            <a class="lostpassword" href="/admin.php?do=lostpassword">Забыли пароль?</a>
        </div>
        <div style="clear:both;"></div>
    </div>
  </body>
</html>