<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://jcat.tk/
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Управление расписанием
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
    $content .= '<tr><th>Время эфира</th><th>День эфира</th><th>Название</th><th colspan="2"><a href="/admin.php?do=schedule&add">Добавить запись</a></th></tr>';
    //Получаем номер страницы (значение лимита 25(кол-во записей на 1 страницу))
    if (isset($_GET['page']) && $_GET['page'] >= 1){$cur_page = $_GET['page'];}
    else {$cur_page = 1;}
    $limit_from = ($cur_page - 1) * 25;
    //Выполняем запрос к БД с последующим выводом записей
    $stmt = $pdo->prepare('SELECT SQL_CALC_FOUND_ROWS * FROM jre_schedule ORDER BY id DESC LIMIT :limit_from,25');
    $stmt->execute(array('limit_from' => $limit_from));
    while($row = $stmt->fetch()){
        if($colored) $block = '<tr style="background-color:#fff;">';
        else $block = '<tr>';
        $order = array('monday','tuesday','wednesday','thursday','friday','saturday','sunday');
        $replace = array('Понедельник','Вторник','Среда','Четверг','Пятница','Суббота','Воскресенье');
        $day = str_replace($order,$replace,$row["day"]);
        $block .= '<td>'.date("H:i",$row["time"]).' - '.date("H:i",$row["endtime"]).'</td>';
        $block .= '<td>'.$day.'</td>';
        $block .= '<td>'.(iconv_strlen($row["title"],'utf-8')>25 ? (iconv_substr($row["title"],0,25,'utf-8')."...") : $row["title"]).'</td>';
        $block .= '<td><a href="/admin.php?do=schedule&edit='.$row["id"].'">Редактировать</a></td>';
        $block .= '<td><a href="/admin.php?do=schedule&del='.$row["id"].'">Удалить</a></td>';
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
                $link .= '<span><a href="/admin.php?do=schedule">1</a></span>';
            else
                $link .= '<span><a href="/admin.php?do=schedule&page='.$page.'/">'.$page.'</a></span>';
        }
        $content .= '<div class="navigation">'.$link.'</div>';
    }
    //Проверяем 'пустые' страницы и выдаём оповещение
    if ($_GET['page'] > $num_pages) $error = true;
    if ($error == true) $content = 'Ошибка: Записей не найдено';
 }
 if (isset($_GET['add'])){
    if(isset($_POST['submit'])){
        $time = mktime($_POST["time_hour"],$_POST["time_minute"]);
        $endtime = mktime($_POST["endtime_hour"],$_POST["endtime_minute"]);
        $stmt = $pdo->prepare('INSERT INTO `jre_schedule`(`day`, `time`, `endtime`, `title`) VALUES (:day, :time, :endtime, :title)');
        $stmt->execute(array('day' => $_POST["day"], 'time' => $time, 'endtime' => $endtime, 'title' => $_POST['title']));
        echo 'Запись успешно добавлена';
    }
    else {
        $content = '<h1>Добавить запись</h1>
        <form class="news" style="text-align:center;width:242px;" action="" method="POST">
            <span>Время эфира</span><br>
            <div style="margin-bottom:10px;">
            <input class="number" required type="number" min="0" max="23" maxlength="2" name="time_hour"> :
            <input class="number" required type="number" min="0" max="59" maxlength="2" step="5" name="time_minute"> -
            <input class="number" required type="number" min="0" max="23" maxlength="2" name="endtime_hour"> :
            <input class="number" required type="number" min="0" max="59" maxlength="2" step="5" name="endtime_minute">
            </div>
            <span>День эфира</span><br>
            <select required style="width:220px;" class="input" size="1" name="day">
              <option value="monday">Понедельник</option>
              <option value="tuesday">Вторник</option>
              <option value="wednesday">Среда</option>
              <option value="thursday">Четверг</option>
              <option value="friday">Пятница</option>
              <option value="saturday">Суббота</option>
              <option value="sunday">Воскресенье</option>
            </select>
            <span>Название программы</span><br>
            <input style="width:220px;" class="input" required type="text" name="title"><br>
            <input class="button" type="submit" value="Добавить" name="submit">
        </form>';
    }
 }
 if (isset($_GET['edit'])){
    if (empty($_GET['edit'])){
        echo 'Ошибка: Не выбрана запись';
    }
    else {
        if(isset($_POST['submit'])){
            $time = mktime($_POST["time_hour"],$_POST["time_minute"]);
            $endtime = mktime($_POST["endtime_hour"],$_POST["endtime_minute"]);
            $stmt = $pdo->prepare('UPDATE `jre_schedule` SET `day`=:day,`time`=:time,`endtime`=:endtime,`title`=:title WHERE `id`=:id');
            $stmt->execute(array('day' => $_POST["day"], 'time' => $time, 'endtime' => $endtime, 'title' => $_POST['title'], 'id' => $_GET['edit']));
            echo 'Запись успешно отредактирована';
        }
        else {
            $stmt = $pdo->prepare('SELECT * FROM jre_schedule WHERE id = :id');
            $stmt->execute(array('id' => $_GET['edit']));
            $row = $stmt->fetch();
            if (empty($row)) {
                echo 'Ошибка: Запись не найдена';
            }
            else {
                $h = date("H",$row["time"]);
                $m = date("i",$row["time"]);
                $eh = date("H",$row["endtime"]);
                $em = date("i",$row["endtime"]);
                $content = '<h1>Редактировать запись</h1>
                <form class="news" style="text-align:center;width:242px;" action="" method="POST">
                    <span>Время эфира</span><br>
                    <div style="margin-bottom:10px;">
                    <input style="width:2.5em;border:solid 1px #ccc;border-radius:3px;padding:2px;" required type="number" min="0" max="23" maxlength="2" name="time_hour" value="'.$h.'"> :
                    <input style="width:2.5em;border:solid 1px #ccc;border-radius:3px;padding:2px;" required type="number" min="0" max="59" maxlength="2" step="5" name="time_minute" value="'.$m.'"> -
                    <input style="width:2.5em;border:solid 1px #ccc;border-radius:3px;padding:2px;" required type="number" min="0" max="23" maxlength="2" name="endtime_hour" value="'.$eh.'"> :
                    <input style="width:2.5em;border:solid 1px #ccc;border-radius:3px;padding:2px;" required type="number" min="0" max="59" maxlength="2" step="5" name="endtime_minute" value="'.$em.'">
                    </div>
                    <span>День эфира</span><br>
                    <select required style="width:220px;" class="input" size="1" name="day">
                      <option'; if($row["day"] == 'monday') $content .= ' selected'; $content .= ' value="monday">Понедельник</option>
                      <option'; if($row["day"] == 'tuesday') $content .= ' selected'; $content .= ' value="tuesday">Вторник</option>
                      <option'; if($row["day"] == 'wednesday') $content .= ' selected'; $content .= ' value="wednesday">Среда</option>
                      <option'; if($row["day"] == 'thursday') $content .= ' selected'; $content .= ' value="thursday">Четверг</option>
                      <option'; if($row["day"] == 'friday') $content .= ' selected'; $content .= ' value="friday">Пятница</option>
                      <option'; if($row["day"] == 'saturday') $content .= ' selected'; $content .= ' value="saturday">Суббота</option>
                      <option'; if($row["day"] == 'sunday') $content .= ' selected'; $content .= ' value="sunday">Воскресенье</option>
                    </select>
                    <span>Название программы</span><br>
                    <input style="width:220px;" class="input" required type="text" name="title" value="'.$row['title'].'"><br>
                    <input class="button" type="submit" value="Сохранить" name="submit">
                </form>';
            }

        }
    }
 }
 if (isset($_GET['del'])) {
    if (empty($_GET['del'])){
        echo 'Ошибка: Не выбрана запись';
    }
    else {
        if(isset($_POST['submit'])){
            $stmt = $pdo->prepare('DELETE FROM `jre_schedule` WHERE `id`=:id');
            $stmt->execute(array('id' => $_GET['del']));
            echo 'Запись успешно удалена';
        }
        else {
            $stmt = $pdo->prepare('SELECT * FROM jre_schedule WHERE id = :id');
            $stmt->execute(array('id' => $_GET['del']));
            $row = $stmt->fetch();
            if (empty($row)) {
                echo 'Ошибка: Запись не найдена';
            }
            else {
                $content = '<h1>Удаление записи</h1>
                <form style="text-align:center;" action="" method="POST">
                    <h3 style="margin:1em 0 0;">Вы действительно хотите удалить запись?</h3>
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