<?php
/*
=======================================
 JCat Radio Engine
---------------------------------------
 *site*
---------------------------------------
 Copyright (c) 2016-2017 Molchanov A.I.
=======================================
 Вывод программ
=======================================
*/
if (!defined('JRE_KEY')) die("Hacking attempt!");
include (ENGINE_DIR . '/classes/db_connect.php');
include (ENGINE_DIR . '/classes/pagination.php');

switch($_GET['show'])
{
    case 'all':
        $seo_title = 'Программы &raquo; '. $config->title;
        $per_page = $config->showprog;
        $content = '';
        
        //получаем номер страницы и значение для лимита
        (isset($_GET['page']) && $_GET['page'] >= 1) ? $cur_page = $_GET['page'] : $cur_page = 1;
        $limit_from = ($cur_page - 1) * $per_page;
        
        //выполняем запрос к БД с последующим выводом новостей
        $stmt = $pdo->prepare('SELECT * FROM programs /*WHERE `show` = 1*/ ORDER BY id DESC LIMIT :limit_from, :per_page');
        $stmt->execute(['limit_from' => $limit_from, 'per_page' => $per_page]);
        while($row = $stmt->fetch()) {
            $tpl->set("{title}", $row["title"]);
            $tpl->set("{description}", $row["description"]);
            $tpl->set('{link}', '/programs/'. $row['alt_name']);
            if ($row["image"]) {
                $tpl->set("{image}", '/uploads/images/programs/' . $row["image"]);
            } else {
                $tpl->set("{image}", '/template/' . $config->tpl_dir . '/images/no_image.png');
            }
            $content .= $tpl->show("progblock");
        }
        if (empty($content)) {
            $content = '<div class="error-alert">
            <b>Внимание! Обнаружена ошибка</b><br>
            На данный момент у нас нет программ или они не указаны.
            </div>';
        }
        //узнаем общее количество страниц и заполняем массив со ссылками

        $stmt = $pdo->query('SELECT COUNT(*) FROM `programs` /*WHERE `show` = 1*/');
        $rows = $stmt->fetchColumn();
        $pagination = Pagination::get('programs', $rows, 25, $cur_page);
        $content .= $pagination['content'];

        //Проверяем 'пустые' страницы и выдаём оповещение
        if (isset($_GET['page']) && $_GET['page'] > $pagination['num_pages']) {
            $page_title = 'Ошибка';
            $content = '<div class="error-alert">
            <b>Внимание! Обнаружена ошибка</b><br>
            По данному адресу публикаций на сайте не найдено.
            </div>';
        }
        $tpl->set("{content}", $content);
        break;

    case 'programs':
        $stmt = $pdo->prepare('SELECT * FROM `programs` WHERE alt_name = :alt');
        $stmt->execute(['alt' => $_GET['alt']]);
        if (empty($data = $stmt->fetch())) {
            include(ROOT_DIR .'/modules/errors/404.php');
            exit;
        }
        $tpl->set('{title}', $data['title']);
        $tpl->set('{description}', $data['description']);
        $tpl->set('{content}', $tpl->show('fullprog'));
        $seo_title = $data['seo_title'];
        $seo_description = $data['seo_description'];
        $seo_keywords = $data['seo_keywords'];
        break;
}
