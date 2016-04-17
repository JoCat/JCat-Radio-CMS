<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://jcat.tk/
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Управление статическими страницами
=====================================
*/
 if (!defined('JRE_KEY')) {
    die("Hacking attempt!");
 }
 include(ENGINE_DIR . '/data/db_config.php');
 include(ENGINE_DIR . '/classes/db_connect.php');
 include ( ENGINE_DIR . '/admin/head.html');
 
 if (!isset($_GET['edit']) && !isset($_GET['del']) && !isset($_GET['add'])){
    $colored = true;
    $content = '<table class="news-table" cellspacing="0">';
    $content .= '<tr><th>Адрес</th><th>Описание</th><th colspan="2"><a href="/admin.php?do=static&add">Добавить страницу</a></th></tr>';
    //Получаем номер страницы (значение лимита 25(кол-во ведущих на 1 страницу))
    if (isset($_GET['page']) && $_GET['page'] >= 1){$cur_page = $_GET['page'];}
    else {$cur_page = 1;}
    $limit_from = ($cur_page - 1) * 25;
    //Выполняем запрос к БД с последующим выводом новостей
    $stmt = $pdo->prepare('SELECT SQL_CALC_FOUND_ROWS * FROM jre_static ORDER BY id DESC LIMIT :limit_from,25');
    $stmt->execute(array('limit_from' => $limit_from));
    while($row = $stmt->fetch()){
        if($colored) $block = '<tr style="background-color:#fff;">';
        else $block = '<tr>';
        $block .= '<td>'.(iconv_strlen($row["link"],'utf-8')>25 ? (iconv_substr($row["link"],0,25,'utf-8')."...") : $row["link"]).'</td>';
        $block .= '<td style="text-align:left;">'.(iconv_strlen($row["title"],'utf-8')>100 ? (iconv_substr($row["title"],0,100,'utf-8')."...") : $row["title"]).'</td>';
        $block .= '<td><a href="/admin.php?do=static&edit='.$row["id"].'">Редактировать</a></td>';
        $block .= '<td><a href="/admin.php?do=static&del='.$row["id"].'">Удалить</a></td>';
        $block .= '</tr>';
        $content .= $block;
        $colored = !$colored;
    }
    $content .= '</table>';
    //Узнаем общее количество страниц и заполняем массив со ссылками
    $stmt = $pdo->query('SELECT FOUND_ROWS()');
    $rows = $stmt->fetchColumn();
    $num_pages = ceil($rows / 25);

    if ($num_pages >= 2){
        //Выводим навигацию по страницам
        $page = 0;
        while ($page++ < $num_pages){ 
            if ($page == $cur_page)
                $link .= '<span><b>'.$page.'</b></span>';
            elseif ($page == 1)
                $link .= '<span><a href="/admin.php?do=static">1</a></span>';
            else
                $link .= '<span><a href="/admin.php?do=static&page='.$page.'/">'.$page.'</a></span>';
        }
        $content .= '<div class="navigation">'.$link.'</div>';
    }
    //Проверяем 'пустые' страницы и выдаём оповещение
    if ($_GET['page'] > $num_pages) $error = true;
    if ($error == true) $content = 'Ошибка: Страницы не найдены';
 }
 if (isset($_GET['add'])){
    if(isset($_POST['submit'])){
        $stmt = $pdo->prepare('INSERT INTO `jre_static`(`link`, `title`, `content`) VALUES (:link,:title,:content)');
        $stmt->execute(array('link' => $_POST['link'], 'title' => $_POST['title'], 'content' => $_POST["content"]));
        echo 'Страница успешно добавлена';
    }
    else {
        $content = '<h1>Добавить страницу</h1>
        <form class="news" action="" method="POST">
            <span>Адрес страницы</span><br>
            <input class="input" required type="text" name="link"><br>
            <span>Заголовок (название)</span><br>
            <input class="input" required type="text" name="title"><br>
            <span>Контент</span><br>
            <textarea required style="padding:10px;" class="input" name="content"></textarea>
            <input class="button" type="submit" value="Добавить" name="submit">
        </form>';
    }
 }
 if (isset($_GET['edit'])){
    if (empty($_GET['edit'])){
        echo 'Ошибка: Не выбрана страница';
    }
    else {
        if(isset($_POST['submit'])){
            $stmt = $pdo->prepare('UPDATE `jre_static` SET `link`=:link,`title`=:title,`content`=:content WHERE `id`=:id');
            $stmt->execute(array('link' => $_POST['link'], 'title' => $_POST['title'], 'content' => $_POST['content'], 'id' => $_GET['edit']));
            echo 'Страница успешно отредактирована';
        }
        else {
            $stmt = $pdo->prepare('SELECT * FROM jre_static WHERE id = :id');
            $stmt->execute(array('id' => $_GET['edit']));
            $rj = $stmt->fetch();
            if (empty($rj)) {
                echo 'Ошибка: Страница не найдена';
            }
            else {
                $content = '<h1>Редактировать страницу</h1>
                <form class="news" action="" method="POST">
            <span>Адрес страницы</span><br>
            <input class="input" required type="text" name="link" value="'.$rj['link'].'"><br>
            <span>Заголовок (название)</span><br>
            <input class="input" required type="text" name="title" value="'.$rj['title'].'"><br>
            <span>Контент</span><br>
            <textarea required style="padding:10px;" class="input" name="content">'.$rj['content'].'</textarea>
            <input class="button" type="submit" value="Сохранить" name="submit">
                </form>';
            }

        }
    }
 }
 if (isset($_GET['del'])) {
    if (empty($_GET['del'])){
        echo 'Ошибка: Не выбрана страница';
    }
    else {
        if(isset($_POST['submit'])){
            $stmt = $pdo->prepare('DELETE FROM `jre_static` WHERE `id`=:id');
            $stmt->execute(array('id' => $_GET['del']));
            echo 'Страница успешно удалена';
        }
        else {
            $stmt = $pdo->prepare('SELECT * FROM jre_static WHERE id = :id');
            $stmt->execute(array('id' => $_GET['del']));
            $rj = $stmt->fetch();
            if (empty($rj)) {
                echo 'Ошибка: Страница не найдена';
            }
            else {
                $content = '<h1>Удаление страницы</h1>
                <form style="text-align:center;" action="" method="POST">
                    <h3 style="margin:1em 0 0;">Вы действительно хотите удалить страницу?</h3>
                    <input class="button" style="width:auto;" type="button" value="Вернутся назад" onClick="javascript:history.back();">
                    <input class="button" style="width:auto;" type="submit" value="Да, удалить" name="submit">
                </form>
                ';
            }
        }
    }
 }
 echo $content;
 include ( ENGINE_DIR . '/admin/footer.html');
?>