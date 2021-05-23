<?php
/*
=======================================
 JCat Radio CMS
---------------------------------------
 https://radio-cms.ru/
---------------------------------------
 Copyright (c) 2016-2021 Molchanov A.I.
=======================================
 Вывод программ
=======================================
*/

require_once ENGINE_DIR . '/classes/db_connect.php';
require_once ENGINE_DIR . '/classes/pagination.php';
require_once ENGINE_DIR . '/classes/error_handler.php';

switch ($_GET['show']) {
    case 'all':
        $seo_title = 'Программы &raquo; ' . $config->title;
        $per_page = $config->prog_num;

        //получаем номер страницы и значение для лимита
        (isset($_GET['page']) && $_GET['page'] >= 1) ? $cur_page = $_GET['page'] : $cur_page = 1;
        $limit_from = ($cur_page - 1) * $per_page;

        //выполняем запрос к БД с последующим выводом новостей
        $stmt = $pdo->prepare('SELECT * FROM programs WHERE `show` = 1 ORDER BY id DESC LIMIT :limit_from, :per_page');
        $stmt->execute(['limit_from' => $limit_from, 'per_page' => $per_page]);
        while ($row = $stmt->fetch()) {
            $programs[] = [
                'title' => $row->title,
                'description' => $row->description,
                'link' => '/programs/' . $row->alt_name,
                'image' => empty($row->image) ?
                    '/template/' . $config->tpl_dir . '/images/no_image.png' :
                    '/uploads/images/programs/' . $row->image
            ];
        }
        if (empty($programs)) {
            $error = '<div class="error-alert">
            <b>Внимание! Обнаружена ошибка</b><br>
            На данный момент у нас нет программ или они не указаны.
            </div>';
        }

        //узнаем общее количество страниц и заполняем массив со ссылками
        $stmt = $pdo->query('SELECT COUNT(*) FROM `programs` WHERE `show` = 1');
        $rows = $stmt->fetchColumn();
        $pagination = Pagination::get('programs', $rows, 25, $cur_page);
        //Проверяем 'пустые' страницы и выдаём оповещение
        if (isset($_GET['page']) && $_GET['page'] > $pagination['num_pages']) {
            $page_title = 'Ошибка';
            $error = '<div class="error-alert">
            <b>Внимание! Обнаружена ошибка</b><br>
            По данному адресу публикаций на сайте не найдено.
            </div>';
        }
        if (isset($error)) {
            echo $error;
        } else {
            $pagination = $pagination['content'];
            require_once $template . '/programs.php';
        }
        break;

    case 'programs':
        $stmt = $pdo->prepare('SELECT * FROM `programs` WHERE alt_name = :alt');
        $stmt->execute(['alt' => $_GET['alt']]);
        if (empty($result = $stmt->fetch())) ErrorHandler::error_notFound();
        $data = [
            'title' => $result->title,
            'description' => $result->description,
            'image' => empty($result->image) ?
                '/template/' . $config->tpl_dir . '/images/no_image.png' :
                '/uploads/images/programs/' . $result->image
        ];
        require_once $template . '/fullprog.php';
        $seo_title = $result->seo_title;
        $seo_description = $result->seo_description;
        $seo_keywords = $result->seo_keywords;
        break;
}
