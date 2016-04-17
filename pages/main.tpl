<!DOCTYPE html>
<html>
<head>
    {head}
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="shortcut icon" href="{dir}/images/radio.ico" />
    <link rel="stylesheet" type="text/css" href="{dir}/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{dir}/css/styles.css">
    <link rel="stylesheet" type="text/css" href="/modules/player/css/jcplayer.css">
</head>
<body>
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
            <li><a href="/listen">Слушать</a></li>
            <li><a href="/rj">Ведущие</a></li>
            <li><a href="/programs">Программы</a></li>
            <li><a href="/schedule">Расписание</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right hidden-sm">
            <li><a href="/admin.php">Админ Панель</a></li>
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
        <p>Тестовый сайт на движке JLE</p>
      </div>
    </div>
    
    <div class="wrapper">
      <div class="container">
       <div class="row">
        <div class="col-md-4">
          <div class="block">
            <div><b>Информация</b></div><hr>
            <div id="jsi-info">Информация о потоке :3</div>            
          </div>
          <div class="block hidden-xs hidden-sm">
            <div><b>Информационный блок</b></div><hr>
            <div>Контент информационного блока</div>            
          </div>
          <div class="block hidden-xs hidden-sm">
            <div><b>Информационный блок</b></div><hr>
            <div>Например социальный виджет (Сообщество в ВК)</div>            
          </div>
        </div>
        <div class="col-md-8">
        {content}
        </div>
      </div>
     </div>
    </div>
    
    <div id="jcp-player"></div>
    
    <!-- Script Start -->
    <script type="text/javascript" src="{dir}/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="{dir}/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{dir}/js/background-slide.js"></script>
    <script type="text/javascript" src="/modules/player/js/jcplayer.js"></script>
    <script type="text/javascript">
    src = 'http://127.0.0.1:8000/live';   //Поток радио эфира
    infolink = 'http://127.0.0.1:8000/info.xsl';   //Информационный файл
    tupd = 1000;    //Время обновления информации (в секундах)(Например 10)
    </script>
    <!-- Script End -->
    
    <!-- Footer -->
    <footer class="hidden-xs">
    <div class="container">
      <div class="left">
        <b>JLE</b> Template 2016. Все права защищены.<br>
        Связаться с администрацией: <a href="mailto:{adm_mail}">{adm_mail}</a><br>
        Дизайн и разработка: <a href="http://vk.com/johny_cat">Johny_Cat</a> (<a href="http://jcat.tk/">JCat.tk</a>)
      </div>
      <div class="right" style="text-align: right;">
        counters<br>
        <span>Работает на движке JRE v{version}</span>
      </div>
    </div>
    </footer>
    <!-- Footer End -->
</body>
</html>