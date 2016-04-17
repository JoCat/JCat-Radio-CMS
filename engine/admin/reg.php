<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://jcat.tk/
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Регистрация пользователя
=====================================
*/
 if (! defined ('JRE_KEY')) {
    die ( "Hacking attempt!" );
 }
 include( ENGINE_DIR . '/data/db_config.php' );
 include( ENGINE_DIR . '/classes/db_connect.php' );
 include( ENGINE_DIR . '/classes/auth_functions.php' );
 $err = array();

 //Выводим сообщение об удачной регистрации
 if(isset($_GET['status']) and $_GET['status'] == 'ok'){
	echo showMessage('Вы успешно зарегистрировались! Пожалуйста активируйте свой аккаунт!');
 }
 //Выводим сообщение об удачной регистрации
 if(isset($_GET['active']) and $_GET['active'] == 'ok')
    {
    header('Refresh:3; URL=http://'. $_SERVER['HTTP_HOST'] .'/admin.php');
    echo showMessage('Ваш аккаунт на '. $_SERVER['HTTP_HOST'] .' успешно активирован!');
	}
 //Производим активацию аккаунта
 if(isset($_GET['key']))
 {
	//Проверяем ключ
	$sql = 'SELECT * 
			FROM `jre_users`
			WHERE `active_hex` = :key';
	//Подготавливаем PDO выражение для SQL запроса
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':key', $_GET['key'], PDO::PARAM_STR);
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if(count($rows) == 0)
		$err[] = 'Ключ активации не верен!';
	
	//Проверяем наличие ошибок и выводим пользователю
	if(count($err) > 0)
		echo showErrorMessage($err);
	else
	{
		//Получаем адрес пользователя
		$login = $rows[0]['login'];
	
		//Активируем аккаунт пользователя
		$sql = 'UPDATE `jre_users`
				SET `status` = 1
				WHERE `login` = :login';
		//Подготавливаем PDO выражение для SQL запроса
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':login', $login, PDO::PARAM_STR);
		$stmt->execute();
		
		/*Перенаправляем пользователя на 
		нужную нам страницу*/
		header('Location:http://'. $_SERVER['HTTP_HOST'] .'/admin.php?do=reg&active=ok');
		exit;
	}
 }
 /*Если нажата кнопка на регистрацию,
 начинаем проверку*/
 if(isset($_POST['submit']))
 {
	//Утюжим пришедшие данные
	if(empty($_POST['login']))
		$err[] = 'Поле Логин не может быть пустым';
    
	if(empty($_POST['email']))
		$err[] = 'Поле Email не может быть пустым!';
	else
	{
		if(emailValid($_POST['email']) === false)
           $err[] = 'Не правильно введен E-mail'."\n";
	}
    
	if(empty($_POST['pass']))
		$err[] = 'Поле Пароль не может быть пустым';
	
	if(empty($_POST['pass2']))
		$err[] = 'Поле подтверждения пароля не может быть пустым';
	
    if(empty($_POST['key']))
    $err[] = 'Поле ключа защиты не может быть пустым!';
    
	//Проверяем наличие ошибок и выводим пользователю
	if(count($err) > 0)
		echo showErrorMessage($err);
	else
	{
		/*Продолжаем проверять введеные данные
		Проверяем на совпадение пароли*/
		if($_POST['pass'] != $_POST['pass2'])
			$err[] = 'Пароли не совподают';
        
        //Проверка ключа защиты
        if($_POST['key'] != $config['reg_key'])
            $err[] = 'Не правильно введен ключ защиты!';
        
		//Проверяем наличие ошибок и выводим пользователю
	    if(count($err) > 0)
			echo showErrorMessage($err);
		else
		{
			/*Проверяем существует ли у нас 
			такой пользователь в БД*/
			$sql = 'SELECT `login`
					FROM `jre_users`
					WHERE `login` = :login';
			//Подготавливаем PDO выражение для SQL запроса
			$stmt = $pdo->prepare($sql);
			$stmt->bindValue(':login', $_POST['login'], PDO::PARAM_STR);
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			if(count($rows) > 0)
				$err[] = 'Пользователь с логином: <b>'. $_POST['login'] .'</b> уже зарегестрирован!';

			$sql = 'SELECT `email`
					FROM `jre_users`
					WHERE `email` = :email';
			//Подготавливаем PDO выражение для SQL запроса
            $stmt = $pdo->prepare($sql);
			$stmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
			if(count($rows) > 0)
				$err[] = 'Пользователь с почтой: <b>'. $_POST['email'] .'</b> уже зарегестрирован!';
            
			//Проверяем наличие ошибок и выводим пользователю
			if(count($err) > 0)
				echo showErrorMessage($err);
			else
			{
				//Получаем ХЕШ соли
				$salt = salt();
				
				//Солим пароль
				$pass = md5(md5($_POST['pass']).$salt);
				
				/*Если все хорошо, пишем данные в базу*/
				$sql = 'INSERT INTO `jre_users`
						VALUES(
								"",
                                :login,
								:pass,
								:email,
								:salt,
								"'. md5($salt) .'",
								0
								)';
				//Подготавливаем PDO выражение для SQL запроса
				$stmt = $pdo->prepare($sql);
				$stmt->bindValue(':login', $_POST['login'], PDO::PARAM_STR);
				$stmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
				$stmt->bindValue(':pass', $pass, PDO::PARAM_STR);
				$stmt->bindValue(':salt', $salt, PDO::PARAM_STR);
				$stmt->execute();
				
				//Отправляем письмо для активации
                $url = 'http://'. $_SERVER['HTTP_HOST'] .'/admin.php?do=reg&key='. md5($salt);
                $message = '
                <html>
                <head>
                  <title>Регистрация на сайте '. $_SERVER['HTTP_HOST'] .'</title>
                </head>
                <body>
                  <p>Для активации Вашего аккаунта пройдите по ссылке: </p>
                  <a href="'. $url .'">Активация аккаунта</a>
                </body>
                </html>
                ';
                
               //Формируем заголовки для почтового сервера
               $headers .= "MIME-Version: 1.0\r\n";
               $headers  = "Content-type: text/html; charset=utf-8" . "\r\n";
               $headers .= "To: ". $_POST['email'] . "\r\n";
               $headers .= "From: ". $config['admin_mail'] ."\r\n";
               $headers .= "Date: ". date('D, d M Y h:i:s O');

               //Отправляем данные на почту
               mail($_POST['email'], 'Регистрация на сайте ' . $_SERVER['HTTP_HOST'], $message, $headers);
                
				//Сбрасываем параметры
				header('Location:http://'. $_SERVER['HTTP_HOST'] .'/admin.php?do=reg&status=ok');
				exit;
			}
		}
	}
 }
?>
    <title>Регистрация &raquo; Админпанель</title>
    <link rel="stylesheet" type="text/css" href="/engine/admin/styles/auth.css">
    <div class="form" style="height:455px;">
        <div class="header">Регистрация</div>
        <form action="" method="POST">
        Логин:
        <input class="input" required placeholder="Введите логин" type="text" name="login">
        Пароль:
        <input class="input" required placeholder="Введите пароль" type="password" maxlength="32" name="pass">
        Повторите пароль:
        <input class="input" required placeholder="Повторите пароль" type="password" maxlength="32" name="pass2">
        E-mail:
        <input class="input" required placeholder="Введите E-Mail" type="text" name="email">
        Ключ защиты:
        <input class="input" required placeholder="Введите ключ защиты" type="text" name="key">
        <input class="button" type="submit" value="Отправить" name="submit">
        <div style="float:left;margin:3px 10px;">
            <a class="lostpassword" href="/admin.php">Авторизация</a><br>
            <a class="lostpassword" href="/admin.php?do=lostpassword">Забыли пароль?</a>
        </div>
        <div style="clear:both;"></div>
    </div>
  </body>
</html>