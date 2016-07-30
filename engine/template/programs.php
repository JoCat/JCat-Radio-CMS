<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://jcat.tk/
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Вывод программ
=====================================
*/
 if (! defined ('JRE_KEY')) {
    die ( "Hacking attempt!" );
 }

 include( ENGINE_DIR . '/data/db_config.php' );
 include( ENGINE_DIR . '/classes/db_connect.php' );

 $show = isset($_GET['show'])  ? $_GET['show'] : false;
	switch($show)
	{
        case 'all':
            $page_title = 'Программы';
            $per_page = $config['showprog'];
            
            //получаем номер страницы и значение для лимита
            if (isset($_GET['page']) && $_GET['page'] >= 1){$cur_page = $_GET['page'];}
            else {$cur_page = 1;}
            $limit_from = ($cur_page - 1) * $per_page;
            
            //выполняем запрос к БД с последующим выводом новостей
            $stmt = $pdo->prepare('SELECT SQL_CALC_FOUND_ROWS * FROM jre_programs ORDER BY id ASC LIMIT :limit_from, :per_page');
            $stmt->execute(array('limit_from' => $limit_from,'per_page' => $per_page));
            while($row = $stmt->fetch()){
                $tpl -> set( "{title}", $row["title"] );
                $tpl -> set( "{info}", $row["info"] );
                if ($row["pic"]) {
                    $tpl -> set( "{pic}", '/pages/images/programs/'.$row["pic"] );
                }else {
                    $tpl -> set( "{pic}", '/pages/images/no_image.png' );
                }
                $content .= $tpl -> showmodule( "progblock.tpl" );
            }
            if (empty($content)){
                $content = '<div class="error-alert">
                <b>Внимание! Обнаружена ошибка</b><br>
                На данный момент у нас нет программ или они не указаны.
                </div>';
            }
            //узнаем общее количество страниц и заполняем массив со ссылками
            $stmt = $pdo->query('SELECT FOUND_ROWS()');
            $rows = $stmt->fetchColumn();
            $num_pages = ceil($rows / $per_page);
            
            if ($num_pages >= 2){
                //Выводим навигацию по страницам
                $page = 0;
                while ($page++ < $num_pages){ 
                    if ($page == $cur_page)
                    $link .= '<span><b>'.$page.'</b></span>';
                    else
                        if ($page == 1)
                            $link .= '<span><a href="/programs">1</a></span>';
                        else
                            $link .= '<span><a href="/programs/'.$page.'/">'.$page.'</a></span>';
                }
                $tpl -> set( "{navigation}", $link );
                $content .= $tpl -> showmodule( "navigation.tpl" );
            }
            
            //Проверяем 'пустые' страницы и выдаём оповещение
            if ($_GET['page'] > $num_pages) $error = true;
            if ($error == true)
            {
                $page_title = 'Ошибка';
                $content = '<div class="error-alert">
                <b>Внимание! Обнаружена ошибка</b><br>
                По данному адресу публикаций на сайте не найдено.
                </div>';
            }
            $tpl -> set( "{content}", $content );
		break;
        
        case 'programs':
            $page_title = $row["name"];
            //Temporarily not working
            $tpl -> set( "{content}", $tpl -> showmodule( "fullprog.tpl" ) );
		break;
	}
    
 $pdo = null;
?>