<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <title>JRE Admin Panel</title>
    <link rel="stylesheet" href="/engine/admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="/engine/admin/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">JRE Admin Panel</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li><a href="admin.php">Управление сайтом</a></li>
            <li><a href="admin.php?do=rj">Панель ведущих</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-bell" aria-hidden="true"></span></a></li>
            <li><a href="#"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <img src="<?= $user->get_avatar() ?>" alt="" class="img-circle user-img">
              <?= $user->get('username') ?>
              <span class="glyphicon glyphicon-chevron-down"></span>
              </a>
              <ul class="dropdown-menu">
                <li><span><?= $user->get('usergroup') ?></span></li>
                <li role="separator" class="divider"></li>
                <li><a href="/">На сайт</a></li>
                <li><a href="#">Управление аккаунтом</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="/admin.php?do=logout">Выход</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <aside>
      <?= $menu->get_sidebar_menu() ?>
    </aside>
    <div class="content">
      <?= $content ?>
    </div>
    <!-- Scripts -->
    <script src="/engine/admin/js/jquery-2.1.4.min.js"></script>
    <script src="/engine/admin/js/bootstrap.min.js"></script>
  </body>
</html>