<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://radiocms.tk
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Управление программами
=====================================
*/
if (!defined('JRE_KEY')) die("Hacking attempt!");
include(ENGINE_DIR . '/data/db_config.php');
include(ENGINE_DIR . '/classes/db_connect.php');
include(ENGINE_DIR . '/classes/pagination.php');
include(ENGINE_DIR . '/admin/head.html');

if (!isset($_GET['edit']) && !isset($_GET['del']) && !isset($_GET['add'])){
    $colored = true;
    $content = '<table class="news-table" cellspacing="0">';
    $content .= '<tr><th>Программа</th><th>Описание</th><th colspan="2"><a href="/admin.php?do=programs&add">Добавить программу</a></th></tr>';
    //Получаем номер страницы (значение лимита 20(кол-во программ на 1 страницу))
    if (isset($_GET['page']) && $_GET['page'] >= 1){$cur_page = $_GET['page'];}
    else {$cur_page = 1;}
    $limit_from = ($cur_page - 1) * 20;
    //Выполняем запрос к БД с последующим выводом новостей
    $stmt = $pdo->prepare('SELECT SQL_CALC_FOUND_ROWS * FROM jre_programs ORDER BY id DESC LIMIT :limit_from,20');
    $stmt->execute(['limit_from' => $limit_from]);
    while($row = $stmt->fetch()){
        $content .= ($colored) ? '<tr style="background-color:#fff;">' : '<tr>';
        $content .= '<td>'.(iconv_strlen($row["title"],'utf-8')>25 ? (iconv_substr($row["title"],0,25,'utf-8')."...") : $row["title"]).'</td>
        <td style="text-align:left;">'.(iconv_strlen($row["info"],'utf-8')>100 ? (iconv_substr($row["info"],0,100,'utf-8')."...") : $row["info"]).'</td>
        <td><a href="/admin.php?do=programs&edit='.$row["id"].'">Редактировать</a></td>
        <td><a href="/admin.php?do=programs&del='.$row["id"].'">Удалить</a></td>
        </tr>';
        $colored = !$colored;
    }
    $content .= '</table>';
    //Узнаем общее количество страниц и заполняем массив со ссылками
    $stmt = $pdo->query('SELECT FOUND_ROWS()');
    $rows = $stmt->fetchColumn();
    $content .= Pagination::getPagination('programs', $rows, 20, $cur_page);
    //Проверяем 'пустые' страницы и выдаём оповещение
    if (isset($_GET['page']) && $_GET['page'] > $num_pages) $error = true;
    if (isset($error) && $error == true) $content = 'Ошибка: Программы не найдены';
}
if (isset($_GET['add'])){
    if(isset($_POST['submit'])){
        $order = ["\r\n", "\n", "\r"];
        $replace = '<br>';
        $text = str_replace($order,$replace,$_POST["text"]);
        $stmt = $pdo->prepare('INSERT INTO `jre_programs`(`title`, `info`, `pic`) VALUES (:title,:info,:pic)');
        $stmt->execute(['info' => $text, 'title' => $_POST['title'], 'pic' => $_POST['pic']]);
        echo 'Программа успешно добавлена';
    }
    else {
        $content = '<h1>Добавить программу</h1>
        <form class="news" action="" method="POST">
            <span>Название</span><br>
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
        echo 'Ошибка: Не выбрана программа';
    }
    else {
        if(isset($_POST['submit'])){
            $order = ["\r\n", "\n", "\r"];
            $replace = '<br>';
            $text = str_replace($order,$replace,$_POST["text"]);
            $stmt = $pdo->prepare('UPDATE `jre_programs` SET `title`=:title,`info`=:info,`pic`=:pic WHERE `id`=:id');
            $stmt->execute(['info' => $text, 'title' => $_POST['title'], 'pic' => $_POST['pic'], 'id' => $_GET['edit']]);
            echo 'Программа успешно отредактирована';
        }
        else {
            $stmt = $pdo->prepare('SELECT * FROM jre_programs WHERE id = :id');
            $stmt->execute(['id' => $_GET['edit']]);
            $rj = $stmt->fetch();
            if (empty($rj)) {
                echo 'Ошибка: Программа не найдена';
            }
            else {
                $rj['info'] = str_replace('<br>',PHP_EOL,$rj['info']);
                $content = '<h1>Редактировать программу</h1>
                <form class="news" action="" method="POST">
                    <span>Название</span><br>
                    <input class="input" required type="text" name="title" value="'.$rj['title'].'"><br>
                    <span>Полное название изображения</span><br>
                    <input class="input" required type="text" name="pic" value="'.$rj['pic'].'"><br>
                    <span>Краткое описание</span><br>
                    <textarea required style="padding:10px;" class="input" name="text">'.$rj['info'].'</textarea>
                    <input class="button" type="submit" value="Сохранить" name="submit">
                </form>';
            }

        }
    }
}
if (isset($_GET['del'])) {
    if (empty($_GET['del'])){
        echo 'Ошибка: Не выбрана программа';
    }
    else {
        if(isset($_POST['submit'])){
            $stmt = $pdo->prepare('DELETE FROM `jre_programs` WHERE `id`=:id');
            $stmt->execute(['id' => $_GET['del']]);
            echo 'Программа успешно удалена';
        }
        else {
            $stmt = $pdo->prepare('SELECT * FROM jre_programs WHERE id = :id');
            $stmt->execute(['id' => $_GET['del']]);
            $rj = $stmt->fetch();
            if (empty($rj)) {
                echo 'Ошибка: Программа не найдена';
            }
            else {
                $content = '<h1>Удаление программы</h1>
                <form style="text-align:center;" action="" method="POST">
                    <h3 style="margin:1em 0 0;">Вы действительно хотите удалить программу?</h3>
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