<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <title>JRE Admin Panel</title>
    <link rel="stylesheet" href="/engine/admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="/engine/admin/css/bootstrap-clockpicker.min.css">
    <link rel="stylesheet" href="/engine/admin/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/admin.php">JRE Admin Panel</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="dropdown visible-xs">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Управление сайтом <span class="caret"></span></a>
              <?= $menu->get_custom_menu('dropdown-menu') ?>
            </li>
            <li class="hidden-xs"><a href="/admin.php">Управление сайтом</a></li>
            <!-- <li><a href="/admin.php?do=rj">Панель ведущих</a></li> -->
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="hidden-xs"><a href="/admin.php?do=settings"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a></li>
            <li class="visible-xs"><a href="/admin.php?do=settings">Настройки сайта</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <img src="<?= $user->get_avatar() ?>" alt="" class="img-circle user-img">
              <?= $user->get('username') ?>
              <span class="glyphicon glyphicon-chevron-down"></span>
              </a>
              <ul class="dropdown-menu">
                <li>
                  <img src="<?= $user->get_avatar() ?>" alt="" class="img-circle user-img-big center-block">
                  <span class="tac"><?= $user->get('username') ?></span>
                  <span class="tac"><?= $user->get('usergroup') ?></span>
                </li>
                <li role="separator" class="divider"></li>
                <li><a href="/" target="_blank">Просмотр сайта</a></li>
                <li class="disabled"><a href="#">Управление аккаунтом</a></li>
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
    <script src="/engine/admin/js/bootstrap-clockpicker.min.js"></script>
  </body>
</html>