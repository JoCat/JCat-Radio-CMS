<?php

use JRC\Common\Components\User;

$user = new User();

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?= $head ?>
    <link rel="shortcut icon" href="/images/radio.ico" />
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
</head>
<body>
    <div class="wrapper">
      <nav class="navbar navbar-fixed-top navbar-default">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <span class="navbar-brand">JRE Template<span class="glyphicon glyphicon-music" aria-hidden="true"></span></span>
          </div>
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-left">
              <li><a href="/">Главная</a></li>
              <li><a href="/news">Новости</a></li>
              <li><a href="/programs">Программы</a></li>
              <li><a href="/schedule">Расписание</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right hidden-sm">
              <?php if ($user->is_user_authed()): ?>
              <li class="dropdown userinfo">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <img src="<?= $user->get_avatar() ?>" alt="" class="img-circle user-img">
                <span class="username"><?= $user->get('username') ?></span>
                <span class="glyphicon glyphicon-chevron-down"></span>
                </a>
                <ul class="dropdown-menu">
                  <li><a href="/admin">Админпанель</a></li>
                  <li><a href="/user/<?= mb_strtolower($user->get('username')) ?>">Профиль</a></li>
                  <li class="disabled"><a href="#">Управление аккаунтом</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="/logout">Выход</a></li>
                </ul>
              </li>
              <?php else: ?>
              <li><a href="/auth">Авторизация</a></li>
              <li><a href="/reg">Регистрация</a></li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </nav>
      
      <noscript class="js_check">
      Для правильной работы сайта рекомендуем включить поддержку JavaScript на нашем сайте.<br>
      Если вы не отключали поддержку JavaScript, то возможно ваш браузер устарел и он не поддерживает JavaScript.
      </noscript>
      
      <div class="placeholder">
        <div class="container">
          <h1>Основной шаблон</h1>
          <p>Тестовый сайт на движке JRE</p>
        </div>
      </div>
      
      <div class="content">
        <div class="container">
          <div class="row">
            <div class="col-md-4">
              <div class="block hidden-xs hidden-sm">
                <div><b>Плеер</b></div><hr>
                <div id="jcp-player"></div>
                <div id="jsi-info">Загрузка...</div>
              </div>
              <div class="block hidden-xs hidden-sm">
                <div><b>Информационный блок</b></div><hr>
                <div>Например социальный виджет (Сообщество в ВК)</div>            
              </div>
            </div>
            <div class="col-md-8" id="pjax-container">
            <?= $content ?>
            </div>
          </div>
        </div>
      </div>
      <div class="push"></div>
    </div>

    <!-- Footer -->
    <footer class="hidden-xs">
    <div class="container">
      <div class="left">
        <b>JRE</b> Template 2016 – <?= date('Y') ?>. Все права защищены.<br>
        Дизайн и разработка: <a target="_blank" href="http://vk.com/johny_cat">Johny_Cat</a> (<a target="_blank" href="http://jocat.ru/">JoCat.ru</a>)
      </div>
      <div class="right">
        counters
      </div>
    </div>
    </footer>
    <!-- Footer End -->

    <!-- Script Start -->
    <script src="/js/jquery-2.1.4.min.js"></script>
    <script src="/js/jquery.pjax.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/background-slide.js"></script>
    <!-- Script End -->
</body>
</html>