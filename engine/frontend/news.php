<?php
/*
=======================================
 JCat Radio Engine
---------------------------------------
 *site*
---------------------------------------
 Copyright (c) 2016-2017 Molchanov A.I.
=======================================
 Вывод новостей
=======================================
*/

include ENGINE_DIR . '/classes/db_connect.php';
include ENGINE_DIR . '/classes/pagination.php';
include ENGINE_DIR . '/classes/helpers.php';
include ENGINE_DIR . '/classes/error_handler.php';

switch ($_GET['show']) {
    case 'shortnews':
        //Присваиваем основные значения
        $seo_title = 'Новости &raquo; ' . $config->title;
        $per_page = $config->news_num;

        //получаем номер страницы и значение для лимита
        (isset($_GET['page']) && $_GET['page'] >= 1) ? $cur_page = $_GET['page'] : $cur_page = 1;
        $limit_from = ($cur_page - 1) * $per_page;

        //выполняем запрос к БД с последующим выводом новостей
        $stmt = $pdo->prepare('SELECT * FROM `news` WHERE `show` = 1 ORDER BY date DESC LIMIT :limit_from, :per_page');
        $stmt->execute(['limit_from' => $limit_from, 'per_page' => $per_page]);
        while ($row = $stmt->fetch()) {
            $news[] = [
                'title' => $row->title,
                'date' => $helpers->get_date($row->date),
                'short_text' => $row->short_text,
                'link' => '/news/' . $row->id . '-' . $row->alt_name
            ];
        }
        if (empty($news)) {
            $error = '<div class="error-alert">
            <b>Внимание! Обнаружена ошибка.</b><br>
            На данный момент у нас нет новостей, заходите позже :)
            </div>';
        }

        //узнаем общее количество страниц и заполняем массив со ссылками
        $stmt = $pdo->query('SELECT COUNT(*) FROM `news` WHERE `show` = 1');
        $rows = $stmt->fetchColumn();
        $pagination = Pagination::get('news', $rows, 25, $cur_page);
        //Проверяем 'пустые' страницы и выдаём оповещение
        if (isset($_GET['page']) && $_GET['page'] > $pagination['num_pages']) {
            $error = '<div class="error-alert">
            <b>Внимание! Обнаружена ошибка.</b><br>
            По данному адресу публикаций на сайте не найдено.
            </div>';
        }
        if (isset($error)) {
            echo $error;
        } else {
            $pagination = $pagination['content'];
            include $template . '/news.php';
        }
        break;

    case 'fullnews':
        //выполняем запрос к БД с последующим выводом новости
        $stmt = $pdo->prepare('SELECT * FROM `news` JOIN `users` ON news.author_id = users.id WHERE news.id = :id and news.alt_name = :alt');
        $stmt->execute(['id' => $_GET['id'], 'alt' => $_GET['alt']]);
        if (empty($result = $stmt->fetch())) ErrorHandler::error_notFound();
        $data = [
            'title' => $result->title,
            'date' => $helpers->get_date($result->date),
            'full_text' => empty($result->full_text) ? $result->short_text : $result->full_text,
            'author' => '<a href="/user/' . strtolower($result->login) . '">' . $result->login . '</a>'
        ];
        include $template . '/fullnews.php';
        $seo_title = $result->seo_title;
        $seo_description = $result->seo_description;
        $seo_keywords = $result->seo_keywords;
        break;
}
