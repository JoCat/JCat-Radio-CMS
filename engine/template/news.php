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
if (!defined('JRE_KEY')) die("Hacking attempt!");
include (ENGINE_DIR . '/classes/db_connect.php');
include (ENGINE_DIR . '/classes/pagination.php');
include (ENGINE_DIR . '/classes/helpers.php');

switch($_GET['show'])
{
    case 'shortnews':
        //Присваиваем основные значения
        $seo_title = 'Новости &raquo; '. $config->title;
        $per_page = $config->shownews;

        //получаем номер страницы и значение для лимита
        (isset($_GET['page']) && $_GET['page'] >= 1) ? $cur_page = $_GET['page'] : $cur_page = 1;
        $limit_from = ($cur_page - 1) * $per_page;

        //выполняем запрос к БД с последующим выводом новостей
        $stmt = $pdo->prepare('SELECT * FROM `news` WHERE `show` = 1 ORDER BY date DESC LIMIT :limit_from, :per_page');
        $stmt->execute(['limit_from' => $limit_from, 'per_page' => $per_page]);
        while($row = $stmt->fetch()) {
            $data[] = [
                'title' => $row["title"],
                'date' => $helpers->get_date($row["date"]),
                'short_text' => $row["short_text"],
                'link' => '/news/'. $row['id'] .'-'. $row['alt_name']
            ];
        }
        if (empty($data)) {
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
        $pagination = $pagination['content'];

        include $template . '/news.php';
        break;

/*    case 'fullnews':
        //выполняем запрос к БД с последующим выводом новости
        $stmt = $pdo->prepare('SELECT * FROM `news` JOIN `users` ON news.author_id = users.id WHERE news.id = :id and news.alt_name = :alt');
        $stmt->execute(['id' => $_GET['id'], 'alt' => $_GET['alt']]);
        if (empty($data = $stmt->fetch())) {
            include(ROOT_DIR .'/modules/errors/404.php');
            exit;
        }
        $tpl->set('{date}', $data['date']);
        $tpl->set('{title}', $data['title']);
        if (!$data['full_text']) $tpl->set('{fullnews}', $data['short_text']);
        else $tpl->set('{fullnews}', $data['full_text']);
        $tpl->set('{author}', '<a href="/user/' . strtolower($data['login']) . '">' . $data['login'] . '</a>');
        $tpl->set('{content}', $tpl->show('fullnews'));
        $seo_title = $data['seo_title'];
        $seo_description = $data['seo_description'];
        $seo_keywords = $data['seo_keywords'];
        break;*/
}
