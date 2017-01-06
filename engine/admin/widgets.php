<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://radiocms.tk
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Управление виджетами главной
    страницы админпанели
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
    $content .= '<tr><th>Название</th><th>Описание</th><th colspan="2"><a href="/admin.php?do=widgets&add">Добавить виджет</a></th></tr>';
    //Получаем номер страницы (значение лимита 10(кол-во виджетов на 1 страницу))
    if (isset($_GET['page']) && $_GET['page'] >= 1){$cur_page = $_GET['page'];}
    else {$cur_page = 1;}
    $limit_from = ($cur_page - 1) * 10;
    //Выполняем запрос к БД с последующим выводом виджетов
    $stmt = $pdo->prepare('SELECT SQL_CALC_FOUND_ROWS * FROM jre_widgets ORDER BY id DESC LIMIT :limit_from,10');
    $stmt->execute(array('limit_from' => $limit_from));
    while($row = $stmt->fetch()){
        $content .= ($colored) ? '<tr style="background-color:#fff;">' : '<tr>';
        $content .= '<td>'.(iconv_strlen($row["name"],'utf-8')>30 ? (iconv_substr($row["name"],0,30,'utf-8')."...") : $row["name"]).'</td>
        <td style="text-align:left;">'.(iconv_strlen($row["text"],'utf-8')>80 ? (iconv_substr($row["text"],0,80,'utf-8')."...") : $row["text"]).'</td>
        <td><a href="/admin.php?do=widgets&edit='.$row["id"].'">Редактировать</a></td>
        <td><a href="/admin.php?do=widgets&del='.$row["id"].'">Удалить</a></td>
        </tr>';
        $colored = !$colored;
    }
    $content .= '</table>';
    //Узнаем общее количество страниц и заполняем массив со ссылками
    $stmt = $pdo->query('SELECT FOUND_ROWS()');
    $rows = $stmt->fetchColumn();
    $content .= Pagination::getPagination('widgets', $rows, 10, $cur_page);
    //Проверяем 'пустые' страницы и выдаём оповещение
    if (isset($_GET['page']) && $_GET['page'] > $num_pages) $error = true;
    if (isset($error) && $error == true) $content = 'Ошибка: Виджеты не найдены';
}
if (isset($_GET['add'])){
    if(isset($_POST['submit'])){
        $stmt = $pdo->prepare('INSERT INTO `jre_widgets`(`name`, `text`) VALUES (:name,:text)');
        $stmt->execute(array('name' => $_POST['name'], 'text' => $_POST["text"]));
        echo 'Виджет успешно добавлен';
    }
    else {
        $content = '<h1>Добавить виджет</h1>
        <form class="news" action="" method="POST">
            <span>Заголовок (название)</span><br>
            <input class="input" required type="text" name="name"><br>
            <span>Текст</span><br>
            <textarea required style="padding:10px;" class="input" name="text"></textarea>
            <input class="button" type="submit" value="Добавить" name="submit">
        </form>';
    }
}
if (isset($_GET['edit'])){
    if (empty($_GET['edit'])){
        echo 'Ошибка: Не выбран виджет';
    }
    else {
        if(isset($_POST['submit'])){
            $stmt = $pdo->prepare('UPDATE `jre_widgets` SET `name`=:name,`text`=:text WHERE `id`=:id');
            $stmt->execute(array('name' => $_POST['name'], 'text' => $_POST['text'], 'id' => $_GET['edit']));
            echo 'Виджет успешно отредактирован';
        }
        else {
            $stmt = $pdo->prepare('SELECT * FROM jre_widgets WHERE id = :id');
            $stmt->execute(array('id' => $_GET['edit']));
            $rj = $stmt->fetch();
            if (empty($rj)) {
                echo 'Ошибка: Виджет не найден';
            }
            else {
                $content = '<h1>Редактировать виджет</h1>
                <form class="news" action="" method="POST">
                    <span>Заголовок (название)</span><br>
                    <input class="input" required type="text" name="name" value="'.$rj['name'].'"><br>
                    <span>Текст</span><br>
                    <textarea required style="padding:10px;" class="input" name="text">'.$rj['text'].'</textarea>
                    <input class="button" type="submit" value="Сохранить" name="submit">
                </form>';
            }

        }
    }
}
if (isset($_GET['del'])) {
    if (empty($_GET['del'])){
        echo 'Ошибка: Не выбран виджет';
    }
    else {
        if(isset($_POST['submit'])){
            $stmt = $pdo->prepare('DELETE FROM `jre_widgets` WHERE `id`=:id');
            $stmt->execute(array('id' => $_GET['del']));
            echo 'Виджет успешно удалён';
        }
        else {
            $stmt = $pdo->prepare('SELECT * FROM jre_widgets WHERE id = :id');
            $stmt->execute(array('id' => $_GET['del']));
            $rj = $stmt->fetch();
            if (empty($rj)) {
                echo 'Ошибка: Виджет не найден';
            }
            else {
                $content = '<h1>Удаление виджета</h1>
                <form style="text-align:center;" action="" method="POST">
                    <h3 style="margin:1em 0 0;">Вы действительно хотите удалить виджет?</h3>
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