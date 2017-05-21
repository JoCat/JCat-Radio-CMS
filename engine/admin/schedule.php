<?php
/*
=======================================
 JCat Radio Engine
---------------------------------------
 *site*
---------------------------------------
 Copyright (c) 2016-2017 Molchanov A.I.
=======================================
 Управление расписанием
=======================================
*/
if (!defined('JRE_KEY')) die ("Hacking attempt!");
include (ENGINE_DIR . '/classes/db_connect.php');
include (ENGINE_DIR . '/classes/pagination.php');
include (ENGINE_DIR . '/classes/helpers.php');

$menu->set_sidebar_menu([
    [
        'name' => 'Главная',
        'link' => '',
    ],
    [
        'name' => 'Новости',
        'link' => '?do=news',
    ],
    [
        'name' => 'Программы',
        'link' => '?do=programs',
    ],
    [
        'name' => 'Расписание',
        'link' => '?do=schedule',
        'active' => true,
    ],
    [
        'name' => 'Статические страницы',
        'link' => '?do=static',
    ],
], 'admin.php');

$days = [
    'monday' => 'Понедельник',
    'tuesday' => 'Вторник',
    'wednesday' => 'Среда',
    'thursday' => 'Четверг',
    'friday' => 'Пятница',
    'saturday' => 'Суббота',
    'sunday' => 'Воскресенье'
];

if (isset($_GET['create'])) {
    if (isset($_POST['submit'])) {
        if (empty($_POST['program'])) echo $helpers->get_error('Не выбрана программа.');
        elseif (empty($_POST['start_time']) && empty($_POST['end_time'])) echo $helpers->get_error('Не указано время начала/завершения эфира.');
        elseif (empty($_POST['day'])) echo $helpers->get_error('Не указан день эфира.');
        else {
            $stmt = $pdo->prepare('INSERT INTO `schedule`(`day`, `program_id`, `start_time`, `end_time`, `show`) VALUES (:day, :program_id, :start_time, :end_time, :show)');
            $stmt->execute([
                'day' => $_POST['day'],
                'program_id' => $_POST['program'],
                'start_time' => $_POST['start_time'],
                'end_time' => $_POST['end_time'],
                'show' => $_POST['show']
            ]);
            echo '<p>Эфир успешно добавлен<br></p>
            <a href="/admin.php?do=schedule" class="btn btn-success">Вернутся назад</a>';
        }
    } else {
        $stmt = $pdo->query('SELECT * FROM `programs` WHERE `show` = 1 ORDER BY id DESC');
        $programs = $stmt->fetchAll();
        include $template . 'views/schedule/create.php';
    }
} elseif (isset($_GET['update'])) {
    if (isset($_POST['submit'])) {
        if (empty($_POST['program'])) echo $helpers->get_error('Не выбрана программа.');
        elseif (empty($_POST['start_time']) && empty($_POST['end_time'])) echo $helpers->get_error('Не указано время начала/завершения эфира.');
        elseif (empty($_POST['day'])) echo $helpers->get_error('Не указан день эфира.');
        else {
            $stmt = $pdo->prepare('UPDATE `schedule` SET `program_id`=:program_id,`day`=:day,`start_time`=:start_time,`end_time`=:end_time,`show`=:show WHERE `id`=:id');
            $stmt->execute([
                'id' => $_GET['update'],
                'day' => $_POST['day'],
                'program_id' => $_POST['program'],
                'start_time' => $_POST['start_time'],
                'end_time' => $_POST['end_time'],
                'show' => $_POST['show']
            ]);
            echo '<p>Эфир успешно изменён<br></p>
            <a href="/admin.php?do=schedule" class="btn btn-success">Вернутся назад</a>';
        }
    } else {
        $stmt = $pdo->query('SELECT * FROM `programs` WHERE `show` = 1 ORDER BY id DESC');
        $programs = $stmt->fetchAll();
        $stmt = $pdo->prepare('SELECT * FROM `schedule` WHERE `id` = :id');
        $stmt->execute(['id' => $_GET['update']]);
        $schedule = $stmt->fetch();
        if (empty($schedule)) echo $helpers->get_error('Эфир не найден.');
        else {
            include $template . 'views/schedule/update.php';
        }
    }
} elseif (isset($_GET['delete'])) {
    if (empty($_GET['delete'])) echo $helpers->get_error('Не выбран эфир.');
    elseif (isset($_POST['submit'])) {
        $stmt = $pdo->prepare('DELETE FROM `schedule` WHERE `id` = :id');
        $stmt->execute(['id' => $_GET['delete']]);
        echo '<p>Эфир успешно удалён<br></p>
        <a href="/admin.php?do=schedule" class="btn btn-success">Вернутся назад</a>';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM `schedule` WHERE `id` = :id');
        $stmt->execute(['id' => $_GET['delete']]);
        $schedule = $stmt->fetch();
        if (empty($schedule)) echo $helpers->get_error('Эфир не найден.');
        else {
            include $template . 'views/schedule/delete.php';
        }
    }
} else {
    //Получаем номер страницы (значение лимита 20(кол-во эфиров на 1 страницу))
    $cur_page = (isset($_GET['page']) && $_GET['page'] >= 1) ? $_GET['page'] : 1;
    $limit_from = ($cur_page - 1) * 20;
    $stmt = $pdo->query('SELECT * FROM `programs` WHERE `show` = 1 ORDER BY id DESC');
    while ($row = $stmt->fetch()) {
        $programs_array[$row['id']] = $row['title'];
    }
    //Выполняем запрос к БД с последующим выводом эфиров
    $stmt = $pdo->prepare('SELECT * FROM `schedule` ORDER BY id DESC LIMIT :limit_from,20');
    $stmt->execute(['limit_from' => $limit_from]);
    while($row = $stmt->fetch()){
        $data[] = [
            'id' => $row['id'],
            'day' => $days[$row['day']],
            'title' => $programs_array[$row['program_id']],
            'start_time' => $helpers->get_time($row['start_time']),
            'end_time' => $helpers->get_time($row['end_time']),
        ];
    }
    //узнаем общее количество страниц и заполняем массив со ссылками
    $stmt = $pdo->query('SELECT COUNT(*) FROM `schedule`');
    $rows = $stmt->fetchColumn();
    $pagination = Pagination::get('schedule', $rows, 20, $cur_page);
    //Проверяем 'пустые' страницы и выдаём оповещение
    if (isset($_GET['page']) && $_GET['page'] > $pagination['num_pages']) {
        echo $helpers->get_error('Эфиры не найдены.');
    } else {
        include $template . 'views/schedule/index.php';
        echo $pagination['content'];
    }
}
