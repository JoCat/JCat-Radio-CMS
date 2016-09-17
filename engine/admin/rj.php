<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://radiocms.tk
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Управление ведущими
=====================================
*/
 if (!defined('JRE_KEY')) {
    die("Hacking attempt!");
 }
 include(ENGINE_DIR . '/data/db_config.php');
 include(ENGINE_DIR . '/classes/db_connect.php');
 include(ENGINE_DIR . '/admin/head.html');
 
 if (!isset($_GET['edit']) && !isset($_GET['del']) && !isset($_GET['add'])){
    $colored = true;
    $content = '<table class="news-table" cellspacing="0">';
    $content .= '<tr><th>Ник</th><th>Описание</th><th colspan="2"><a href="/admin.php?do=rj&add">Добавить ведущего</a></th></tr>';
    //Получаем номер страницы (значение лимита 10(кол-во ведущих на 1 страницу))
    if (isset($_GET['page']) && $_GET['page'] >= 1){$cur_page = $_GET['page'];}
    else {$cur_page = 1;}
    $limit_from = ($cur_page - 1) * 10;
    //Выполняем запрос к БД с последующим выводом новостей
    $stmt = $pdo->prepare('SELECT SQL_CALC_FOUND_ROWS * FROM jre_rj ORDER BY id DESC LIMIT :limit_from,10');
    $stmt->execute(array('limit_from' => $limit_from));
    while($row = $stmt->fetch()){
        if($colored) $block = '<tr style="background-color:#fff;">';
        else $block = '<tr>';
        $block .= '<td>'.(iconv_strlen($row["name"],'utf-8')>25 ? (iconv_substr($row["name"],0,25,'utf-8')."...") : $row["name"]).'</td>';
        $block .= '<td style="text-align:left;">'.(iconv_strlen($row["description"],'utf-8')>100 ? (iconv_substr($row["description"],0,100,'utf-8')."...") : $row["description"]).'</td>';
        $block .= '<td><a href="/admin.php?do=rj&edit='.$row["id"].'">Редактировать</a></td>';
        $block .= '<td><a href="/admin.php?do=rj&del='.$row["id"].'">Удалить</a></td>';
        $block .= '</tr>';
        $content .= $block;
        $colored = !$colored;
    }
    $content .= '</table>';
    //Узнаем общее количество страниц и заполняем массив со ссылками
    $stmt = $pdo->query('SELECT FOUND_ROWS()');
    $rows = $stmt->fetchColumn();
    $num_pages = ceil($rows / 10);

    if ($num_pages >= 2){
        //Выводим навигацию по страницам
        $page = 0;
        while ($page++ < $num_pages){ 
            if ($page == $cur_page)
                $link .= '<span><b>'.$page.'</b></span>';
            elseif ($page == 1)
                $link .= '<span><a href="/admin.php?do=rj">1</a></span>';
            else
                $link .= '<span><a href="/admin.php?do=rj&page='.$page.'/">'.$page.'</a></span>';
        }
        $content .= '<div class="navigation">'.$link.'</div>';
    }
    //Проверяем 'пустые' страницы и выдаём оповещение
    if ($_GET['page'] > $num_pages) $error = true;
    if ($error == true) $content = 'Ошибка: Ведущих не найдено';
 }
 if (isset($_GET['add'])){
    if(isset($_POST['submit'])){
        $order = array("\r\n", "\n", "\r");
        $replace = '<br>';
        $text = str_replace($order,$replace,$_POST["text"]);
        $stmt = $pdo->prepare('INSERT INTO `jre_rj`(`name`, `description`, `pic`) VALUES (:name,:description,:pic)');
        $stmt->execute(array('description' => $text, 'name' => $_POST['title'], 'pic' => $_POST['pic']));
        echo 'Ведущий успешно добавлен';
    }
    else {
        $content = '<h1>Добавить ведущего</h1>
        <form class="news" action="" method="POST">
            <span>Ник</span><br>
            <input class="input" required type="text" name="title"><br>
            <span>Полное название изображения</span><br>
            <input class="input" required type="text" name="pic"><br>
            <span>Краткое описание</span><br>
            <textarea required style="padding:10px;" class="input" name="text"></textarea>
            <input class="button" type="submit" value="Добавить" name="submit">
        </form>';
    }
 }
 if (isset($_GET['edit'])){
    if (empty($_GET['edit'])){
        echo 'Ошибка: Не выбран ведущий';
    }
    else {
        if(isset($_POST['submit'])){
            $order = array("\r\n", "\n", "\r");
            $replace = '<br>';
            $text = str_replace($order,$replace,$_POST["text"]);
            $stmt = $pdo->prepare('UPDATE `jre_rj` SET `name`=:name,`description`=:description,`pic`=:pic WHERE `id`=:id');
            $stmt->execute(array('description' => $text, 'name' => $_POST['title'], 'pic' => $_POST['pic'], 'id' => $_GET['edit']));
            echo 'Ведущий успешно отредактирован';
        }
        else {
            $stmt = $pdo->prepare('SELECT * FROM jre_rj WHERE id = :id');
            $stmt->execute(array('id' => $_GET['edit']));
            $rj = $stmt->fetch();
            if (empty($rj)) {
                echo 'Ошибка: Ведущий не найден';
            }
            else {
                $rj['description'] = str_replace('<br>',PHP_EOL,$rj['description']);
                $content = '<h1>Редактировать ведущего</h1>
                <form class="news" action="" method="POST">
                    <span>Ник</span><br>
                    <input class="input" required type="text" name="title" value="'.$rj['name'].'"><br>
                    <span>Полное название изображения</span><br>
                    <input class="input" required type="text" name="pic" value="'.$rj['pic'].'"><br>
                    <span>Краткое описание</span><br>
                    <textarea required style="padding:10px;" class="input" name="text">'.$rj['description'].'</textarea>
                    <input class="button" type="submit" value="Сохранить" name="submit">
                </form>';
            }

        }
    }
 }
 if (isset($_GET['del'])) {
    if (empty($_GET['del'])){
        echo 'Ошибка: Не выбран ведущий';
    }
    else {
        if(isset($_POST['submit'])){
            $stmt = $pdo->prepare('DELETE FROM `jre_rj` WHERE `id`=:id');
            $stmt->execute(array('id' => $_GET['del']));
            echo 'Ведущий успешно удален';
        }
        else {
            $stmt = $pdo->prepare('SELECT * FROM jre_rj WHERE id = :id');
            $stmt->execute(array('id' => $_GET['del']));
            $rj = $stmt->fetch();
            if (empty($rj)) {
                echo 'Ошибка: Ведущий не найден';
            }
            else {
                $content = '<h1>Удаление ведущего</h1>
                <form style="text-align:center;" action="" method="POST">
                    <h3 style="margin:1em 0 0;">Вы действительно хотите удалить ведущего?</h3>
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