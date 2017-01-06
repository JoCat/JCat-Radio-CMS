<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://radiocms.tk
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Вывод новостей
=====================================
*/
if (!defined('JRE_KEY')) die("Hacking attempt!");
include(ENGINE_DIR . '/data/db_config.php');
include(ENGINE_DIR . '/classes/db_connect.php');

$show = isset($_GET['show']) ? $_GET['show'] : false;
switch($show)
{
    case 'shortnews':
        //Присваиваем основные значения
        $page_title = 'Новости';
        $per_page = $config['shownews'];

        //получаем номер страницы и значение для лимита
        (isset($_GET['page']) && $_GET['page'] >= 1) ? $cur_page = $_GET['page'] : $cur_page = 1;
        $limit_from = ($cur_page - 1) * $per_page;

        //выполняем запрос к БД с последующим выводом новостей
        $stmt = $pdo->prepare('SELECT SQL_CALC_FOUND_ROWS * FROM `jre_news` ORDER BY date DESC LIMIT :limit_from, :per_page');
        $stmt->execute(array('limit_from' => $limit_from,'per_page' => $per_page));
        while($row = $stmt->fetch())
        {
            $tpl->set("{date}", date("d/m/Y - H:i",$row["date"]));
            $tpl->set("{title}", $row["title"]);
            $tpl->set("{news}", $row["news"]);
            $tpl->set("{link}", '/news/'. $row["id"] .'-'. $row["alt_name"]);
            $content .= $tpl->showmodule("newsblock.tpl");
        }
        if (empty($content))
        {
            $content = '<div class="error-alert">
            <b>Внимание! Обнаружена ошибка</b><br>
            На данный момент у нас нет новостей, заходите позже :)
            </div>';
        }
        //узнаем общее количество страниц и заполняем массив со ссылками
        $stmt = $pdo->query('SELECT FOUND_ROWS()');
        $rows = $stmt->fetchColumn();
        $num_pages = ceil($rows / $per_page);

        if ($num_pages >= 2)
        {
            //Выводим навигацию по страницам
            $page = 0;
            while ($page++ < $num_pages)
            { 
                if ($page == $cur_page)
                $link .= '<span><b>'. $page .'</b></span>';
                else
                    if ($page == 1)
                        $link .= '<span><a href="/news">1</a></span>';
                    else
                        $link .= '<span><a href="/news/'.$page.'/">'.$page.'</a></span>';
            }
            $tpl->set("{navigation}", $link);
            $content .= $tpl->showmodule("navigation.tpl");
        }

        //Проверяем 'пустые' страницы и выдаём оповещение
        if ($_GET['page'] > $num_pages) $error = true;
        if ($error == true)
        {
            $content = '<div class="error-alert">
            <b>Внимание! Обнаружена ошибка</b><br>
            По данному адресу публикаций на сайте не найдено.
            </div>';
        }
        $tpl->set("{content}", $content);
    break;

    case 'fullnews':
        //выполняем запрос к БД с последующим выводом новости
        $stmt = $pdo->prepare('SELECT * FROM jre_news WHERE id = :id and alt_name = :alt_name');
        $stmt->execute(array('id' => $_GET['id'], 'alt_name' => $_GET['alt']));
        $row = $stmt->fetch();
        if (empty($row))
        {
            include(ROOT_DIR .'/modules/errors/404.php');
            exit;
        }
        $tpl->set("{date}", date("d/m/Y - H:i",$row["date"]));
        $tpl->set("{title}", $row["title"]);
        if (!$row["fullnews"]) $tpl->set("{fullnews}", $row["news"]);
        else $tpl->set("{fullnews}", $row["fullnews"]);
        $tpl->set("{content}", $tpl->showmodule("fullnews.tpl"));
        $page_title = $row["title"];
    break;
}
