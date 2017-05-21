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
            $stmt->execute([
                'title' => $_POST['title'],
                'alt_name' => $alt_name,
                'short_text' => $_POST["short_text"],
                'full_text' => $_POST["full_text"],
                'show' => $_POST["show"],
                'author_id' => $author_id['id'],
                'seo_title' => $seo_title,
                'seo_description' => $_POST["seo_description"],
                'seo_keywords' => $_POST["seo_keywords"]
            ]);
            echo '<p>Новость успешно добавлена<br></p>
            <a href="/admin.php?do=news" class="btn btn-success">Вернутся назад</a>';
        }
    } else {
        include $template . '/views/news/create.php';
    }
} elseif (isset($_GET['update'])) {
    if (empty($_GET['update'])) echo $helpers->get_error('Не выбрана новость.');
    elseif (isset($_POST['submit'])) {
        $alt_name = empty($_POST['alt_name']) ? Url::str2url($_POST['title']) : $_POST['alt_name'];
        $seo_title = empty($_POST['seo_title']) ? $_POST['title'] . ' &raquo; '. $config->title : $_POST['seo_title'];
        $stmt = $pdo->prepare('UPDATE `news` SET `title`=:title,`alt_name`=:alt_name,`short_text`=:short_text,`full_text`=:full_text,`show`=:show,`seo_title`=:seo_title,`seo_description`=:seo_description,`seo_keywords`=:seo_keywords WHERE `id`=:id');
        $stmt->execute([
            'id' => $_GET['update'],
            'title' => $_POST['title'],
            'alt_name' => $alt_name,
            'short_text' => $_POST["short_text"],
            'full_text' => $_POST["full_text"],
            'show' => $_POST["show"],
            'seo_title' => $seo_title,
            'seo_description' => $_POST["seo_description"],
            'seo_keywords' => $_POST["seo_keywords"],
        ]);
        echo '<p>Новость успешно отредактирована<br></p>
        <a href="/admin.php?do=news" class="btn btn-success">Вернутся назад</a>';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM `news` WHERE `id`=:id');
        $stmt->execute(['id' => $_GET['update']]);
        $news = $stmt->fetch();
        if (empty($news)) echo $helpers->get_error('Новость не найдена.');
        else {
            include $template . '/views/news/update.php';
        }
    }
} elseif (isset($_GET['delete'])) {
    if (empty($_GET['delete'])) echo $helpers->get_error('Не выбрана новость.');
    elseif (isset($_POST['submit'])) {
        $stmt = $pdo->prepare('DELETE FROM `news` WHERE `id`=:id');
        $stmt->execute(['id' => $_GET['delete']]);
        echo '<p>Новость успешно удалена<br></p>
        <a href="/admin.php?do=news" class="btn btn-success">Вернутся назад</a>';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM `news` WHERE `id`=:id');
        $stmt->execute(['id' => $_GET['delete']]);
        $news = $stmt->fetch();
        if (empty($news)) echo $helpers->get_error('Новость не найдена.');
        else {
            include $template . '/views/news/delete.php';
        }
    }
} else {
    //Получаем номер страницы (значение лимита 25(кол-во новостей на 1 страницу))
    $cur_page = (isset($_GET['page']) && $_GET['page'] >= 1) ? $_GET['page'] : 1;
    $limit_from = ($cur_page - 1) * 20;
    //Выполняем запрос к БД с последующим выводом новостей
    $stmt = $pdo->prepare('SELECT * FROM `news` ORDER BY date DESC LIMIT :limit_from,20');
    $stmt->execute(['limit_from' => $limit_from]);
    while($row = $stmt->fetch()){
        $data[] = [
            'id' => $row['id'],
            'title' => iconv_strlen($row['title'], 'utf-8') > 25 ?
                iconv_substr($row['title'], 0, 25, 'utf-8') . '...' :
                $row['title'],
            'date' => $helpers->get_date($row["date"]),
            'short_text' => iconv_strlen($row["short_text"], 'utf-8') > 100 ?
                iconv_substr($row["short_text"], 0, 100, 'utf-8') . '...' :
                $row["short_text"]
        ];
    }
    //узнаем общее количество страниц и заполняем массив со ссылками
    $stmt = $pdo->query('SELECT COUNT(*) FROM `news`');
    $rows = $stmt->fetchColumn();
    $pagination = Pagination::get('news', $rows, 20, $cur_page);
    //Проверяем 'пустые' страницы и выдаём оповещение
    if (isset($_GET['page']) && $_GET['page'] > $pagination['num_pages']) {
        echo $helpers->get_error('Публикации не найдены.');
    } else {
        include $template . '/views/news/index.php';
        echo $pagination['content'];
    }
}
