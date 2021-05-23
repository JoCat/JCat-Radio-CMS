<?php
/*
=======================================
 JCat Radio CMS
---------------------------------------
 https://radio-cms.ru/
---------------------------------------
 Copyright (c) 2016-2021 Molchanov A.I.
=======================================
 Управление группами
=======================================
*/

require_once ENGINE_DIR . '/classes/db_connect.php';
require_once ENGINE_DIR . '/classes/pagination.php';
require_once ENGINE_DIR . '/classes/purifier.php';
require_once ENGINE_DIR . '/classes/helpers.php';
require_once ENGINE_DIR . '/classes/url.php';

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
    ],
    [
        'name' => 'Статические страницы',
        'link' => '?do=static',
    ],
    [
        'name' => 'Пользователи',
        'link' => '?do=users',
    ],
    [
        'name' => 'Группы пользователей',
        'link' => '?do=users_group',
        'active' => true,
    ],
], 'admin.php');

if ($user->get('groups_edit')) {
    if (isset($_GET['create'])) {
        if (isset($_POST['submit'])) {
            if (empty($_POST['name'])) echo $helpers->get_error('Не указано название группы');
            else {
                $stmt = $pdo->prepare('INSERT INTO `user_groups`(`name`, `is_admin`, `news_edit`, `programs_edit`, `schedule_edit`, `page_edit`, `users_view`, `users_edit`, `groups_edit`) VALUES (:name, :is_admin, :news_edit, :programs_edit, :schedule_edit, :page_edit, :users_view, :users_edit, :groups_edit)');
                $stmt->execute([
                    'name' => $_POST['name'],
                    'is_admin' => $_POST['is_admin'],
                    'news_edit' => $_POST['news_edit'],
                    'programs_edit' => $_POST['programs_edit'],
                    'schedule_edit' => $_POST['schedule_edit'],
                    'page_edit' => $_POST['page_edit'],
                    'users_view' => $_POST['users_view'],
                    'users_edit' => $_POST['users_edit'],
                    'groups_edit' => $_POST['groups_edit']
                ]);
                echo '<p>Группа успешно добавлена</p>
                <a href="/admin.php?do=users_group" class="btn btn-success">Вернутся назад</a>';
            }
        } else {
            require_once $template . 'views/users_group/create.php';
        }
    } elseif (isset($_GET['edit'])) {
        if (isset($_POST['submit'])) {
            if (empty($_POST['name'])) echo $helpers->get_error('Не указано название группы');
            else {
                $stmt = $pdo->prepare('UPDATE `user_groups` SET `name`=:name,`is_admin`=:is_admin,`news_edit`=:news_edit,`programs_edit`=:programs_edit,`schedule_edit`=:schedule_edit,`page_edit`=:page_edit,`users_view`=:users_view,`users_edit`=:users_edit,`groups_edit`=:groups_edit WHERE `id`=:id');
                $stmt->execute([
                    'id' => $_GET['edit'],
                    'name' => $_POST['name'],
                    'is_admin' => $_POST['is_admin'],
                    'news_edit' => $_POST['news_edit'],
                    'programs_edit' => $_POST['programs_edit'],
                    'schedule_edit' => $_POST['schedule_edit'],
                    'page_edit' => $_POST['page_edit'],
                    'users_view' => $_POST['users_view'],
                    'users_edit' => $_POST['users_edit'],
                    'groups_edit' => $_POST['groups_edit']
                ]);
                echo '<p>Группа успешно изменена</p>
                <a href="/admin.php?do=users_group" class="btn btn-success">Вернутся назад</a>';
            }
        } else {
            $stmt = $pdo->prepare('SELECT * FROM `user_groups` WHERE id = :id');
            $stmt->execute(['id' => $_GET['edit']]);
            $data = $stmt->fetch();
            if (empty($data)) echo $helpers->get_error('Группа не найдена');
            else {
                require_once $template . 'views/users_group/edit.php';
            }
        }
    } elseif (isset($_GET['delete'])) {
        if (empty($_GET['delete'])) echo $helpers->get_error('Не выбранa группа');
        elseif (isset($_POST['submit'])) {
            $stmt = $pdo->prepare('DELETE FROM `user_groups` WHERE `id` = :id');
            $stmt->execute(['id' => $_GET['delete']]);
            echo '<p>Группа успешно удалена</p>
            <a href="/admin.php?do=users_group" class="btn btn-success">Вернутся назад</a>';
        } else {
            $stmt = $pdo->prepare('SELECT * FROM `user_groups` WHERE `id` = :id');
            $stmt->execute(['id' => $_GET['delete']]);
            $data = $stmt->fetch();
            if (empty($data)) echo $helpers->get_error('Группа не найдена');
            else {
                require_once $template . 'views/users_group/delete.php';
            }
        }
    } else {
        $cur_page = (isset($_GET['page']) && $_GET['page'] >= 1) ? $_GET['page'] : 1;
        $limit_from = ($cur_page - 1) * 20;

        $stmt = $pdo->prepare('SELECT * FROM `user_groups` ORDER BY `id` LIMIT :limit_from,20');
        $stmt->execute(['limit_from' => $limit_from]);
        $data = $stmt->fetchAll();

        $stmt = $pdo->query('SELECT COUNT(*) FROM `user_groups`');
        $rows = $stmt->fetchColumn();

        $pagination = Pagination::get('user_groups', $rows, 20, $cur_page);
        if (isset($_GET['page']) && $_GET['page'] > $pagination['num_pages']) {
            echo $helpers->get_error('Группы не найдены');
        } else {
            require_once $template . 'views/users_group/index.php';
            echo $pagination['content'];
        }
    }
} else {
    echo '<h1 class="text-center">Доступ закрыт</h1>
<h2 class="text-center">Недостаточно прав</h2>
<div class="text-center">
<button class="btn btn-primary" type="button" onClick="javascript:history.back();">Вернутся назад</button>
</div>';
}
