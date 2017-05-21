<?php
/*
=======================================
 JCat Radio Engine
---------------------------------------
 *site*
---------------------------------------
 Copyright (c) 2016-2017 Molchanov A.I.
=======================================
 Управление новостями
=======================================
*/
if (!defined('JRE_KEY')) die ("Hacking attempt!");
include (ENGINE_DIR . '/classes/db_connect.php');
include (ENGINE_DIR . '/classes/pagination.php');
include (ENGINE_DIR . '/classes/helpers.php');
include (ENGINE_DIR . '/classes/url.php');

$menu->set_sidebar_menu([
    [
        'name' => 'Главная',
        'link' => '',
    ],
    [
        'name' => 'Новости',
        'link' => '?do=news',
        'active' => true,
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
], 'admin.php');

$method = isset($_GET['method']) ? $_GET['method'] : false;
switch ($method) {
    case 'create':
        # code...
        break;

    case 'update':
        # code...
        break;

    case 'delete':
        # code...
        break;
    
    default:
        //Получаем номер страницы (значение лимита 25(кол-во новостей на 1 страницу))
        $cur_page = (isset($_GET['page']) && $_GET['page'] >= 1) ? $_GET['page'] : 1;
        $limit_from = ($cur_page - 1) * 10;
        //Выполняем запрос к БД с последующим выводом новостей
        $stmt = $pdo->prepare('SELECT * FROM `news` ORDER BY date DESC LIMIT :limit_from,10');
        $stmt->execute(['limit_from' => $limit_from]);
        while($row = $stmt->fetch()){
            $data[] = [
                'id' => $row['id'],
                'title' => iconv_strlen($row['title'], 'utf-8') > 25 ?
                    iconv_substr($row['title'], 0, 25, 'utf-8') . '...' :
                    $row['title'],
                'date' => $helpers->get_date($row["date"]),
                'short_text' => iconv_strlen($row["short_text"], 'utf-8') > 100 ?
                    iconv_substr($row["short_text"], 0, 100, 'utf-8') . '...' :
                    $row["short_text"]
            ];
        }
        //узнаем общее количество страниц и заполняем массив со ссылками
        $stmt = $pdo->query('SELECT COUNT(*) FROM `news`');
        $rows = $stmt->fetchColumn();
        $pagination = Pagination::get('news', $rows, 10, $cur_page);
        //Проверяем 'пустые' страницы и выдаём оповещение
        if (isset($_GET['page']) && $_GET['page'] > $pagination['num_pages']): ?>
            <div class="error-alert">
              <b>Внимание! Обнаружена ошибка.</b><br>
              Публикации не найдены.
            </div>
        <?php else: ?>
          <div class="panel panel-default">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Дата создания</th>
                  <th>Заголовок</th>
                  <th>Краткое содержание</th>
                  <th colspan="2" width="100" align="center">Управление</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($data as $row): ?>
                <tr>
                  <td><?= $row['date'] ?></td>
                  <td><?= $row['title'] ?></td>
                  <td><?= $row['short_text'] ?></td>
                  <td width="50" align="center"><span class="glyphicon glyphicon-edit" aria-hidden="true" title="Изменить"></span></td>
                  <td width="50" align="center"><span class="glyphicon glyphicon-remove" aria-hidden="true" title="Удалить"></span></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <?php echo $pagination['content'];
        endif;
        break;
}