<?php
/*
=======================================
 JCat Radio Engine
---------------------------------------
 *site*
---------------------------------------
 Copyright (c) 2016-2017 Molchanov A.I.
=======================================
 Управление программами
=======================================
*/
if (!defined('JRE_KEY')) die ("Hacking attempt!");
include (ENGINE_DIR . '/classes/upload_image.php');
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
    ],
    [
        'name' => 'Программы',
        'link' => '?do=programs',
        'active' => true,
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
        if (empty($_POST['title'])) echo $helpers->get_error('Не указано название программы.');
        elseif (empty($_POST['description'])) echo $helpers->get_error('Не указано описание программы.');
        else {
            $alt_name = empty($_POST['alt_name']) ? Url::str2url($_POST['title']) : $_POST['alt_name'];
            $seo_title = empty($_POST['seo_title']) ? strip_tags($_POST['title']) . ' &raquo; '. $config->title : $_POST['seo_title'];
            if (empty($_FILES['image']['name'])) {
                $image = null;
            } else {
                $uploadImage = new UploadImage;
                $imageLoad = $uploadImage->imageLoad($_FILES['image'], 'programs', $alt_name);
                $image = $alt_name . '.' . $uploadImage->getExt($_FILES['image']['name']);
            }
            if (!empty($imageLoad)) {
                echo $helpers->get_error('Ошибка при загрузке изображения: ' . $imageLoad);
            } else {
                $stmt = $pdo->prepare('INSERT INTO `programs`(`title`, `alt_name`, `description`, `image`, `show`, `seo_title`, `seo_description`, `seo_keywords`) VALUES (:title, :alt_name, :description, :image, :show, :seo_title, :seo_description, :seo_keywords)');
                $purifier = load_htmlpurifier($allowed);
                $stmt->execute([
                    'title' => strip_tags($_POST['title']),
                    'alt_name' => strip_tags($alt_name),
                    'description' => $purifier->purify($_POST['description']),
                    'image' => $image,
                    'show' => $_POST['show'],
                    'seo_title' => strip_tags($seo_title),
                    'seo_description' => strip_tags($_POST['seo_description']),
                    'seo_keywords' => strip_tags($_POST['seo_keywords'])
                ]);
                echo '<p>Программа успешно добавлена</p>
                <a href="/admin.php?do=programs" class="btn btn-success">Вернутся назад</a>';
            }
        }
    } else {
        include $template . 'views/programs/create.php';
    }
} elseif (isset($_GET['update'])) {
    if (empty($_GET['update'])) echo $helpers->get_error('Не выбрана программа.');
    elseif (isset($_POST['submit'])) {
        if (empty($_POST['title'])) echo $helpers->get_error('Не указано название программы.');
        elseif (empty($_POST['description'])) echo $helpers->get_error('Не указано описание программы.');
        else {
            $alt_name = empty($_POST['alt_name']) ? Url::str2url($_POST['title']) : $_POST['alt_name'];
            $seo_title = empty($_POST['seo_title']) ? strip_tags($_POST['title']) . ' &raquo; '. $config->title : $_POST['seo_title'];
            if (empty($_FILES['image']['name'])) {
                if (isset($_POST['old_image'])) {
                    $image = $_POST['old_image'];
                } else {
                    $image = null;
                }
            } else {
                $uploadImage = new UploadImage;
                $imageLoad = $uploadImage->imageLoad($_FILES['image'], 'programs', $alt_name);
                $image = $alt_name . '.' . $uploadImage->getExt($_FILES['image']['name']);
            }
            if (!empty($imageLoad)) {
                echo $helpers->get_error('Ошибка при загрузке изображения: ' . $imageLoad);
            } else {
                $stmt = $pdo->prepare('UPDATE `programs` SET `title`=:title,`alt_name`=:alt_name,`description`=:description,`image`=:image,`show`=:show,`seo_title`=:seo_title,`seo_description`=:seo_description,`seo_keywords`=:seo_keywords WHERE `id`=:id');
                $purifier = load_htmlpurifier($allowed);
                $stmt->execute([
                    'id' => $_GET['update'],
                    'title' => strip_tags($_POST['title']),
                    'alt_name' => strip_tags($alt_name),
                    'description' => $purifier->purify($_POST['description']),
                    'image' => $image,
                    'show' => $_POST['show'],
                    'seo_title' => strip_tags($seo_title),
                    'seo_description' => strip_tags($_POST['seo_description']),
                    'seo_keywords' => strip_tags($_POST['seo_keywords'])
                ]);
                echo '<p>Программа успешно отредактирована</p>
                <a href="/admin.php?do=programs" class="btn btn-success">Вернутся назад</a>';
            }
        }
    } else {
        $stmt = $pdo->prepare('SELECT * FROM `programs` WHERE `id` = :id');
        $stmt->execute(['id' => $_GET['update']]);
        $programs = $stmt->fetch();
        if (empty($programs)) echo $helpers->get_error('Программа не найдена.');
        else {
            include $template . 'views/programs/update.php';
        }
    }
} elseif (isset($_GET['delete'])) {
    if (empty($_GET['delete'])) echo $helpers->get_error('Не выбрана программа.');
    else {
        $stmt = $pdo->prepare('SELECT * FROM `programs` WHERE `id` = :id');
        $stmt->execute(['id' => $_GET['delete']]);
        $programs = $stmt->fetch();
        if (empty($programs)) echo $helpers->get_error('Программа не найдена.');
        else {
            if (isset($_POST['submit'])) {
                if (!empty($programs->image)) {
                    $uploadImage = new UploadImage;
                    $uploadImage->imageDelete('programs', $programs->image);
                }
                $stmt = $pdo->prepare('DELETE FROM `programs` WHERE `id` = :id');
                $stmt->execute(['id' => $_GET['delete']]);
                echo '<p>Программа успешно удалена</p>
                <a href="/admin.php?do=programs" class="btn btn-success">Вернутся назад</a>';
            } else {
                include $template . 'views/programs/delete.php';
            }
        }
    }
} else {
    //Получаем номер страницы (значение лимита 20(кол-во программ на 1 страницу))
    $cur_page = (isset($_GET['page']) && $_GET['page'] >= 1) ? $_GET['page'] : 1;
    $limit_from = ($cur_page - 1) * 20;
    //Выполняем запрос к БД с последующим выводом программ
    $stmt = $pdo->prepare('SELECT * FROM `programs` ORDER BY id DESC LIMIT :limit_from,20');
    $stmt->execute(['limit_from' => $limit_from]);
    $data = $stmt->fetchAll();
    //узнаем общее количество страниц и заполняем массив со ссылками
    $stmt = $pdo->query('SELECT COUNT(*) FROM `programs`');
    $rows = $stmt->fetchColumn();
    $pagination = Pagination::get('programs', $rows, 20, $cur_page);
    //Проверяем 'пустые' страницы и выдаём оповещение
    if (isset($_GET['page']) && $_GET['page'] > $pagination['num_pages']) {
        echo $helpers->get_error('Программы не найдены.');
    } else {
        include $template . 'views/programs/index.php';
        echo $pagination['content'];
    }
}
