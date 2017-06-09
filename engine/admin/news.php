<?php
/*
=======================================
 JCat Radio Engine
---------------------------------------
 *site*
---------------------------------------
 Copyright (c) 2016-2017 Molchanov A.I.
=======================================
 Управление новостями
=======================================
*/
if (!defined('JRE_KEY')) die ("Hacking attempt!");
include (ENGINE_DIR . '/classes/db_connect.php');
include (ENGINE_DIR . '/classes/pagination.php');
include (ENGINE_DIR . '/classes/purifier.php');
include (ENGINE_DIR . '/classes/helpers.php');
include (ENGINE_DIR . '/classes/url.php');

$menu->set_sidebar_menu([
    [
        'name' => 'Главная',
        'link' => '',
    ],
    [
        'name' => 'Новости',
        'link' => '?do=news',
        'active' => true,
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
    ],
], 'admin.php');

if (isset($_GET['create'])) {
    if (isset($_POST['submit'])) {
        if (empty($_POST['title'])) echo $helpers->get_error('Не указано название новости.');
        elseif (empty($_POST['short_text'])) echo $helpers->get_error('Не указано краткое содержание новости.');
        else {
            $alt_name = empty($_POST['alt_name']) ? Url::str2url($_POST['title']) : $_POST['alt_name'];
            $seo_title = empty($_POST['seo_title']) ? $_POST['title'] . ' &raquo; '. $config->title : $_POST['seo_title'];
            $stmt = $pdo->prepare('SELECT `id` FROM `users` WHERE login = :login');
            $stmt->execute(['login' => $user->get('username')]);
            $author_id = $stmt->fetch();
            $stmt = $pdo->prepare('INSERT INTO `news`(`title`, `alt_name`, `short_text`, `full_text`, `show`, `author_id`, `seo_title`, `seo_description`, `seo_keywords`) VALUES (:title, :alt_name, :short_text, :full_text, :show, :author_id, :seo_title, :seo_description, :seo_keywords)');
            $purifier = load_htmlpurifier($allowed);
            $stmt->execute([
                'title' => strip_tags($_POST['title']),
                'alt_name' => strip_tags($alt_name),
                'short_text' => $purifier->purify($_POST['short_text']),
                'full_text' => $purifier->purify($_POST['full_text']),
                'show' => $_POST['show'],
                'author_id' => $author_id->id,
                'seo_title' => strip_tags($seo_title),
                'seo_description' => strip_tags($_POST['seo_description']),
                'seo_keywords' => strip_tags($_POST['seo_keywords'])
            ]);
            echo '<p>Новость успешно добавлена</p>
            <a href="/admin.php?do=news" class="btn btn-success">Вернутся назад</a>';
        }
    } else {
        include $template . 'views/news/create.php';
    }
} elseif (isset($_GET['update'])) {
    if (empty($_GET['update'])) echo $helpers->get_error('Не выбрана новость.');
    elseif (isset($_POST['submit'])) {
        if (empty($_POST['title'])) echo $helpers->get_error('Не указано название новости.');
        elseif (empty($_POST['short_text'])) echo $helpers->get_error('Не указано краткое содержание новости.');
        else {
            $alt_name = empty($_POST['alt_name']) ? Url::str2url($_POST['title']) : $_POST['alt_name'];
            $seo_title = empty($_POST['seo_title']) ? $_POST['title'] . ' &raquo; '. $config->title : $_POST['seo_title'];
            $stmt = $pdo->prepare('UPDATE `news` SET `title`=:title,`alt_name`=:alt_name,`short_text`=:short_text,`full_text`=:full_text,`show`=:show,`seo_title`=:seo_title,`seo_description`=:seo_description,`seo_keywords`=:seo_keywords WHERE `id`=:id');
            $purifier = load_htmlpurifier($allowed);
            $stmt->execute([
                'id' => $_GET['update'],
                'title' => strip_tags($_POST['title']),
                'alt_name' => strip_tags($alt_name),
                'short_text' => $purifier->purify($_POST['short_text']),
                'full_text' => $purifier->purify($_POST['full_text']),
                'show' => $_POST['show'],
                'seo_title' => strip_tags($seo_title),
                'seo_description' => strip_tags($_POST['seo_description']),
                'seo_keywords' => strip_tags($_POST['seo_keywords'])
            ]);
            echo '<p>Новость успешно отредактирована</p>
            <a href="/admin.php?do=news" class="btn btn-success">Вернутся назад</a>';
        }
    } else {
        $stmt = $pdo->prepare('SELECT * FROM `news` WHERE `id` = :id');
        $stmt->execute(['id' => $_GET['update']]);
        $news = $stmt->fetch();
        if (empty($news)) echo $helpers->get_error('Новость не найдена.');
        else {
            include $template . 'views/news/update.php';
        }
    }
} elseif (isset($_GET['delete'])) {
    if (empty($_GET['delete'])) echo $helpers->get_error('Не выбрана новость.');
    elseif (isset($_POST['submit'])) {
        $stmt = $pdo->prepare('DELETE FROM `news` WHERE `id` = :id');
        $stmt->execute(['id' => $_GET['delete']]);
        echo '<p>Новость успешно удалена</p>
        <a href="/admin.php?do=news" class="btn btn-success">Вернутся назад</a>';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM `news` WHERE `id` = :id');
        $stmt->execute(['id' => $_GET['delete']]);
        $news = $stmt->fetch();
        if (empty($news)) echo $helpers->get_error('Новость не найдена.');
        else {
            include $template . 'views/news/delete.php';
        }
    }
} else {
    //Получаем номер страницы (значение лимита 20(кол-во новостей на 1 страницу))
    $cur_page = (isset($_GET['page']) && $_GET['page'] >= 1) ? $_GET['page'] : 1;
    $limit_from = ($cur_page - 1) * 20;
    //Выполняем запрос к БД с последующим выводом новостей
    $stmt = $pdo->prepare('SELECT * FROM `news` ORDER BY date DESC LIMIT :limit_from,20');
    $stmt->execute(['limit_from' => $limit_from]);
    $data = $stmt->fetchAll();
    //узнаем общее количество страниц и заполняем массив со ссылками
    $stmt = $pdo->query('SELECT COUNT(*) FROM `news`');
    $rows = $stmt->fetchColumn();
    $pagination = Pagination::get('news', $rows, 20, $cur_page);
    //Проверяем 'пустые' страницы и выдаём оповещение
    if (isset($_GET['page']) && $_GET['page'] > $pagination['num_pages']) {
        echo $helpers->get_error('Публикации не найдены.');
    } else {
        include $template . 'views/news/index.php';
        echo $pagination['content'];
    }
}
