<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://radiocms.tk
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Управление новостями
=====================================
*/
 if (!defined('JRE_KEY')) {
    die("Hacking attempt!");
 }
 include(ENGINE_DIR . '/data/db_config.php');
 include(ENGINE_DIR . '/classes/db_connect.php');
 include(ENGINE_DIR . '/classes/url.php');
 include(ENGINE_DIR . '/admin/head.html');
 
 if (!isset($_GET['edit']) && !isset($_GET['del']) && !isset($_GET['add'])){
    $colored = true;
    $content = '<table class="news-table" cellspacing="0">';
    $content .= '<tr><th>Дата создания</th><th>Заголовок</th><th>Описание</th><th colspan="2"><a href="/admin.php?do=news&add">Добавить новость</a></th></tr>';
    //Получаем номер страницы (значение лимита 25(кол-во новостей на 1 страницу))
    if (isset($_GET['page']) && $_GET['page'] >= 1){$cur_page = $_GET['page'];}
    else {$cur_page = 1;}
    $limit_from = ($cur_page - 1) * 25;
    //Выполняем запрос к БД с последующим выводом новостей
    $stmt = $pdo->prepare('SELECT SQL_CALC_FOUND_ROWS * FROM `jre_news` ORDER BY `date` DESC LIMIT :limit_from,25');
    $stmt->execute(array('limit_from' => $limit_from));
    while($row = $stmt->fetch()){
        if($colored) $block = '<tr style="background-color:#fff;">';
        else $block = '<tr>';
        $block .= '<td>'.date("d/m/Y - H:i",$row["date"]).'</td>';
        $block .= '<td>'.(iconv_strlen($row["title"],'utf-8')>25 ? (iconv_substr($row["title"],0,25,'utf-8')."...") : $row["title"]).'</td>';
        $block .= '<td style="text-align:left;">'.(iconv_strlen($row["news"],'utf-8')>100 ? (iconv_substr($row["news"],0,100,'utf-8')."...") : $row["news"]).'</td>';
        $block .= '<td><a href="/admin.php?do=news&edit='.$row["id"].'">Редактировать</a></td>';
        $block .= '<td><a href="/admin.php?do=news&del='.$row["id"].'">Удалить</a></td>';
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
                $link .= '<span><a href="/admin.php?do=news">1</a></span>';
            else
                $link .= '<span><a href="/admin.php?do=news&page='.$page.'/">'.$page.'</a></span>';
        }
        $content .= '<div class="navigation">'.$link.'</div>';
    }
    //Проверяем 'пустые' страницы и выдаём оповещение
    if ($_GET['page'] > $num_pages) $error = true;
    if ($error == true) $content = 'Ошибка: Публикаций не найдено';
 }
 if (isset($_GET['add'])){
    if(isset($_POST['submit'])){
        $order = array("\r\n", "\n", "\r");
        $replace = '<br>';
        $news = str_replace($order,$replace,$_POST["news"]);
        $fullnews = str_replace($order,$replace,$_POST["fullnews"]);
        $link = str2url($_POST['title']);
        $stmt = $pdo->prepare('INSERT INTO `jre_news` (`date`,`news`,`fullnews`,`title`,`alt_name`) VALUES (:date,:news,:fullnews,:title,:alt_name)');
        $stmt->execute(array('date' => time(), 'news' => $news, 'fullnews' => $fullnews, 'title' => $_POST['title'], 'alt_name' => $link));
        echo 'Новость успешно добавлена';
        echo '<br><a href="/admin.php?do=news"><button class="button" style="width:auto;">Вернутся назад</button></a>';
    }
    else {
        $content = '<h1>Добавить новость</h1>
        <form class="news" action="" method="POST">
            <span>Заголовок новости</span><br>
            <input class="input" required type="text" name="title"><br>
            <span>Краткое описание</span><br>
            <textarea required style="padding:10px;" class="input" name="news"></textarea>
            <span>Текст новости</span><br>
            <textarea required style="padding:10px;" class="input" name="fullnews"></textarea>
            <input class="button" type="submit" value="Добавить" name="submit">
        </form>';
    }
 }
 if (isset($_GET['edit'])){
    if (empty($_GET['edit'])){
        echo 'Ошибка: Не выбрана новость';
    }
    else {
        if(isset($_POST['submit'])){
            $order = array("\r\n", "\n", "\r");
            $replace = '<br>';
            $news = str_replace($order,$replace,$_POST["news"]);
            $fullnews = str_replace($order,$replace,$_POST["fullnews"]);
            $stmt = $pdo->prepare('UPDATE `jre_news` SET `date`=:date,`news`=:news,`fullnews`=:fullnews,`title`=:title WHERE `id`=:id');
            $stmt->execute(array('date' => time(), 'news' => $news, 'fullnews' => $fullnews, 'title' => $_POST['title'], 'id' => $_GET['edit']));
            echo 'Новость успешно отредактирована';
            echo '<br><a href="/admin.php?do=news"><button class="button" style="width:auto;">Вернутся назад</button></a>';
        }
        else {
            $stmt = $pdo->prepare('SELECT * FROM `jre_news` WHERE `id`=:id');
            $stmt->execute(array('id' => $_GET['edit']));
            $news = $stmt->fetch();
            if (empty($news)) {
                echo 'Ошибка: Новость не найдена';
            }
            else {
                $news['news'] = str_replace('<br>',PHP_EOL,$news['news']);
                $content = '<h1>Редактировать новость</h1>
                <form class="news" action="" method="POST">
                    <span>Заголовок новости</span><br>
                    <input class="input" required type="text" name="title" value="'.$news['title'].'"><br>
                    <span>Краткое описание</span><br>
                    <textarea required style="padding:10px;" class="input" name="news">'.$news['news'].'</textarea>
                    <span>Текст новости</span><br>
                    <textarea required style="padding:10px;" class="input" name="fullnews">'.$news['fullnews'].'</textarea>
                    <input class="button" type="submit" value="Сохранить" name="submit">
                </form>';
            }

        }
    }
 }
 if (isset($_GET['del'])) {
    if (empty($_GET['del'])){
        echo 'Ошибка: Не выбрана новость';
    }
    else {
        if(isset($_POST['submit'])){
            $stmt = $pdo->prepare('DELETE FROM `jre_news` WHERE `id`=:id');
            $stmt->execute(array('id' => $_GET['del']));
            echo 'Новость успешно удалена';
            echo '<br><a href="/admin.php?do=news"><button class="button" style="width:auto;">Вернутся назад</button></a>';
        }
        else {
            $stmt = $pdo->prepare('SELECT * FROM `jre_news` WHERE `id`=:id');
            $stmt->execute(array('id' => $_GET['del']));
            $news = $stmt->fetch();
            if (empty($news)) {
                echo 'Ошибка: Новость не найдена';
            }
            else {
                $content = '<h1>Удаление новости</h1>
                <form style="text-align:center;" action="" method="POST">
                    <h3 style="margin:1em 0 0;">Вы действительно хотите удалить новость?</h3>
                    <input class="button" style="width:auto;" type="button" value="Вернутся назад" onClick="javascript:history.back();">
                    <input class="button" style="width:auto;" type="submit" value="Да, удалить" name="submit">
                </form>
                ';
            }
        }
    }
 }
 echo $content;
 include(ENGINE_DIR . '/admin/footer.html');
?>