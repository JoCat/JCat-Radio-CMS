<?php
/*
=======================================
 JCat Radio CMS
---------------------------------------
 https://radio-cms.ru/
---------------------------------------
 Copyright (c) 2016-2021 Molchanov A.I.
=======================================
 Управление статическими страницами
=======================================
*/

require_once ENGINE_DIR . '/classes/db_connect.php';
require_once ENGINE_DIR . '/classes/pagination.php';
require_once ENGINE_DIR . '/classes/purifier.php';
require_once ENGINE_DIR . '/classes/helpers.php';
require_once ENGINE_DIR . '/classes/url.php';

$menu->set_sidebar_menu([
    [
        'name' => 'Главная',
        'link' => '',
    ],
    [
        'name' => 'Новости',
        'link' => '?do=news',
    ],
    [
        'name' => 'Программы',
        'link' => '?do=programs',
    ],
    [
        'name' => 'Расписание',
        'link' => '?do=schedule',
    ],
    [
        'name' => 'Статические страницы',
        'link' => '?do=static',
        'active' => true,
    ],
    [
        'name' => 'Пользователи',
        'link' => '?do=users',
    ],
    [
        'name' => 'Группы пользователей',
        'link' => '?do=users_group',
    ],
], 'admin.php');

if ($user->get('page_edit')) {
    if (isset($_GET['create'])) {
        if (isset($_POST['submit'])) {
            if (empty($_POST['url'])) echo $helpers->get_error('Не указана ссылка на страницу.');
            elseif (empty($_POST['content'])) echo $helpers->get_error('Отсутствует контент страницы.');

            /*
             * При повторении url /  обработать и выкинуть предупреждение
             * Fatal error: Uncaught exception 'PDOException' with message 'SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'about' for key 'url'' in C:\OpenServer\domains\jrc.test\engine\admin\static.php:57 Stack trace: #0 C:\OpenServer\domains\jrc.test\engine\admin\static.php(57): PDOStatement->execute(Array) #1 C:\OpenServer\domains\jrc.test\engine\admin.php(43): require_once('C:\\OpenServer\\d...') #2 C:\OpenServer\domains\jrc.test\admin.php(27): require_once('C:\\OpenServer\\d...') #3 {main} thrown in C:\OpenServer\domains\jrc.test\engine\admin\static.php on line 57
            */

            else {
                $stmt = $pdo->prepare('INSERT INTO `static_page`(`url`, `content`, `seo_title`, `seo_description`, `seo_keywords`) VALUES (:url,:content,:seo_title,:seo_description,:seo_keywords)');
                $purifier = load_htmlpurifier($allowed);
                $stmt->execute([
                    'url' => $_POST['url'],
                    'content' => $_POST['content'],
                    'seo_title' => $purifier->purify($_POST['seo_title']),
                    'seo_description' => $purifier->purify($_POST['seo_description']),
                    'seo_keywords' => $purifier->purify($_POST['seo_keywords'])
                ]);
                echo '<p>Страница успешно добавлена</p>
                <a href="/admin.php?do=static" class="btn btn-success">Вернутся назад</a>';
            }
        } else {
            require_once $template . 'views/static/create.php';
        }
    } elseif (isset($_GET['update'])) {
        if (empty($_GET['update'])) echo $helpers->get_error('Не выбрана cтраница.');
        elseif (isset($_POST['submit'])) {
            if (empty($_POST['url'])) echo $helpers->get_error('Не указана ссылка на страницу.');
            elseif (empty($_POST['content'])) echo $helpers->get_error('Отсутствует контент страницы.');
            else {
                $stmt = $pdo->prepare('UPDATE `static_page` SET `url`=:url,`content`=:content,`seo_title`=:seo_title,`seo_description`=:seo_description,`seo_keywords`=:seo_keywords WHERE `id`=:id');
                $purifier = load_htmlpurifier($allowed);
                $stmt->execute([
                    'id' => $_GET['update'],
                    'url' => $_POST['url'],
                    'content' => $_POST['content'],
                    'seo_title' => $purifier->purify($_POST['seo_title']),
                    'seo_description' => $purifier->purify($_POST['seo_description']),
                    'seo_keywords' => $purifier->purify($_POST['seo_keywords'])
                ]);
                echo '<p>Страница успешно отредактирована</p>
                <a href="/admin.php?do=static" class="btn btn-success">Вернутся назад</a>';
            }
        } else {
            $stmt = $pdo->prepare('SELECT * FROM `static_page` WHERE `id` = :id');
            $stmt->execute(['id' => $_GET['update']]);
            $static = $stmt->fetch();
            if (empty($static)) echo $helpers->get_error('Страница не найдена.');
            else {
                require_once $template . 'views/static/update.php';
            }
        }
    } elseif (isset($_GET['delete'])) {
        if (empty($_GET['delete'])) echo $helpers->get_error('Не выбрана страница.');
        elseif (isset($_POST['submit'])) {
            $stmt = $pdo->prepare('DELETE FROM `static_page` WHERE `id` = :id');
            $stmt->execute(['id' => $_GET['delete']]);
            echo '<p>Страница успешно удалена</p>
            <a href="/admin.php?do=static" class="btn btn-success">Вернутся назад</a>';
        } else {
            $stmt = $pdo->prepare('SELECT * FROM `static_page` WHERE `id` = :id');
            $stmt->execute(['id' => $_GET['delete']]);
            $static = $stmt->fetch();
            if (empty($static)) echo $helpers->get_error('Страница не найдена.');
            else {
                require_once $template . 'views/static/delete.php';
            }
        }
    } else {
        //Получаем номер страницы (значение лимита 20(кол-во статических страниц на 1 страницу))
        $cur_page = (isset($_GET['page']) && $_GET['page'] >= 1) ? $_GET['page'] : 1;
        $limit_from = ($cur_page - 1) * 20;
        //Выполняем запрос к БД с последующим выводом статических страниц
        $stmt = $pdo->prepare('SELECT * FROM `static_page` ORDER BY id DESC LIMIT :limit_from,20');
        $stmt->execute(['limit_from' => $limit_from]);
        $data = $stmt->fetchAll();
        //узнаем общее количество страниц и заполняем массив со ссылками
        $stmt = $pdo->query('SELECT COUNT(*) FROM `static_page`');
        $rows = $stmt->fetchColumn();
        $pagination = Pagination::get('static', $rows, 20, $cur_page);
        //Проверяем 'пустые' страницы и выдаём оповещение
        if (isset($_GET['page']) && $_GET['page'] > $pagination['num_pages']) {
            echo $helpers->get_error('Страницы не найдены.');
        } else {
            require_once $template . 'views/static/index.php';
            echo $pagination['content'];
        }
    }
} else {
    echo '<h1 class="text-center">Доступ закрыт</h1>
<h2 class="text-center">Недостаточно прав</h2>
<div class="text-center">
<button class="btn btn-primary" type="button" onClick="javascript:history.back();">Вернутся назад</button>
</div>';
}
