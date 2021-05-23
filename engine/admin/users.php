<?php
/*
=======================================
 JCat Radio CMS
---------------------------------------
 https://radio-cms.ru/
---------------------------------------
 Copyright (c) 2016-2021 Molchanov A.I.
=======================================
 Управление пользователями
=======================================
*/

include ENGINE_DIR . '/classes/db_connect.php';
include ENGINE_DIR . '/classes/pagination.php';
include ENGINE_DIR . '/classes/purifier.php';
include ENGINE_DIR . '/classes/helpers.php';
include ENGINE_DIR . '/classes/url.php';

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
        'active' => true,
    ],
    [
        'name' => 'Группы пользователей',
        'link' => '?do=users_group',
    ],
], 'admin.php');

if ($user->get('users_view')) {
    if (isset($_GET['edit'])) {
        if ($user->get('users_edit')) {
            if (isset($_POST['submit'])) {
                if (empty($_POST['login'])) echo $helpers->get_error('Не указан логин');
                elseif (empty($_POST['email'])) echo $helpers->get_error('Не указана эл. почта');
                else {
                    $execute = [
                        'id' => $_GET['edit'],
                        'login' => $_POST['login'],
                        'email' => $_POST['email'],
                        'user_group' => $_POST['user_group']
                    ];
                    if (!empty($_POST['password'])) {
                        $stmt = $pdo->prepare('UPDATE `users` SET `login`=:login,`password`=:password,`email`=:email,`usergroup_id`=:user_group WHERE `id`=:id');
                        $execute['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    } else {
                        $stmt = $pdo->prepare('UPDATE `users` SET `login`=:login,`usergroup_id`=:user_group,`email`=:email WHERE `id`=:id');
                    }
                    $stmt->execute($execute);

                    echo '<p>Пользователь успешно изменён</p>
                    <a href="/admin.php?do=users" class="btn btn-success">Вернутся назад</a>';
                }
            } else {
                $stmt = $pdo->prepare('SELECT * FROM `users` JOIN `user_groups` WHERE users.usergroup_id = user_groups.id AND users.id = :id');
                $stmt->execute(['id' => $_GET['edit']]);
                $data = $stmt->fetch();

                $stmt = $pdo->query('SELECT * FROM `user_groups`');
                $usergroups = $stmt->fetchAll();

                if (empty($data)) echo $helpers->get_error('Пользователь не найден');
                else {
                    include $template . 'views/users/edit.php';
                }
            }
        } else {
            echo '<h1 class="tac">Доступ закрыт</h1>
            <h2 class="tac">Недостаточно прав</h2>
            <div class="tac">
            <button class="btn btn-primary" type="button" onClick="javascript:history.back();">Вернутся назад</button>
            </div>';
        }
    } elseif (isset($_GET['delete'])) {
        if (empty($_GET['delete'])) echo $helpers->get_error('Не выбран пользователь');
        elseif (isset($_POST['submit'])) {
            $stmt = $pdo->prepare('DELETE FROM `users` WHERE `id` = :id');
            $stmt->execute(['id' => $_GET['delete']]);
            echo '<p>Пользователь успешно удалён</p>
            <a href="/admin.php?do=users" class="btn btn-success">Вернутся назад</a>';
        } else {
            $stmt = $pdo->prepare('SELECT * FROM `users` WHERE `id` = :id');
            $stmt->execute(['id' => $_GET['delete']]);
            $data = $stmt->fetch();
            if (empty($data)) echo $helpers->get_error('Пользователь не найден');
            else {
                include $template . 'views/users/delete.php';
            }
        }
    } else {
        $cur_page = (isset($_GET['page']) && $_GET['page'] >= 1) ? $_GET['page'] : 1;
        $limit_from = ($cur_page - 1) * 20;

        $stmt = $pdo->prepare('SELECT `users`.id, `users`.login, `users`.email, `user_groups`.name FROM `users` JOIN `user_groups` ON users.usergroup_id = user_groups.id ORDER BY users.id ASC LIMIT :limit_from,20');
        $stmt->execute(['limit_from' => $limit_from]);
        $data = $stmt->fetchAll();

        $stmt = $pdo->query('SELECT COUNT(*) FROM `users`');
        $rows = $stmt->fetchColumn();

        $pagination = Pagination::get('users', $rows, 20, $cur_page);
        if (isset($_GET['page']) && $_GET['page'] > $pagination['num_pages']) {
            echo $helpers->get_error('Пользователи не найдены');
        } else {
            include $template . 'views/users/index.php';
            echo $pagination['content'];
        }
    }
} else {
    echo '<h1 class="tac">Доступ закрыт</h1>
<h2 class="tac">Недостаточно прав</h2>
<div class="tac">
<button class="btn btn-primary" type="button" onClick="javascript:history.back();">Вернутся назад</button>
</div>';
}
