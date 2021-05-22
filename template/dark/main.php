<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Rage Radio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="/template/dark/css/main.css">
    <link rel="stylesheet" href="/template/dark/css/iceplayer.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <a class="navbar-brand" href="/">
            <img src="/template/dark/images/logo.svg" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/news">Новости</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/programs">Программы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/schedule">Расписание</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <?php if ($user->is_user_authed()) : ?>
                    <li class="nav-item dropdown userinfo">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="<?= $user->get_avatar() ?>" alt="" class="rounded-circle user-img">
                            <span class="username"><?= $user->get('username') ?></span>
                            <span class="glyphicon glyphicon-chevron-down"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <?php if ($user->get('is_admin') == true) : ?>
                                <a class="dropdown-item not-pjax" href="/admin.php">Админпанель</a>
                            <?php endif; ?>
                            <a class="dropdown-item" href="/user/<?= mb_strtolower($user->get('username')) ?>">Профиль</a>
                            <a class="dropdown-item disabled">Управление аккаунтом</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item not-pjax" href="/logout">Выход</a>
                        </div>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/auth">Авторизация</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/reg">Регистрация</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <main role="main">
        <noscript class="js_check alert alert-danger" role="alert">
            Для правильной работы сайта рекомендуем включить поддержку JavaScript на нашем сайте.<br>
            Если вы не отключали поддержку JavaScript, то возможно ваш браузер устарел и он не поддерживает JavaScript.
        </noscript>
        <div class="placeholder"></div>

        <div class="container">
            <div class="row">
                <aside class="col-md-4">
                    <div class="custom-card">
                        <div class="card-header">
                            Наше радио
                        </div>
                        <div class="card-body">
                            <div id="ice-player"></div>
                        </div>
                    </div>
                    <div class="custom-card">
                        <div class="card-header">
                            Эфиры сегодня
                        </div>
                        <div class="card-body">
                            <?php include ROOT_DIR . '/modules/schedule.php'; ?>
                        </div>
                    </div>
                </aside>

                <div class="col-md-8" id="pjax-container">
                    <?= $content ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <b>JRE</b> Template Dark 2018–2021. Все права защищены.<br>
            <span class="d-none d-md-inline">Дизайн и разработка: <a target="_blank" href="https://jocat.ru/">JoCat</a></span>
        </div>
    </footer>
    <!-- Footer End -->

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="/template/dark/js/iceplayer.min.js"></script>
    <script type="text/javascript">
        new IcePlayer('#ice-player', {
            server_address: 'https://air.radiorecord.ru:805/',
            stream_mount: 'rr_320',
            style: 'inline',
        });
    </script>
    <!-- End scripts -->
</body>

</html>
