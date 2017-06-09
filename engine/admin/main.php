<?php
/*
=======================================
 JCat Radio Engine
---------------------------------------
 *site*
---------------------------------------
 Copyright (c) 2016-2017 Molchanov A.I.
=======================================
 Админпанель
=======================================
*/
if (!defined('JRE_KEY')) die ("Hacking attempt!");
include (ENGINE_DIR . '/classes/db_connect.php');
include (ENGINE_DIR . '/classes/helpers.php');

$menu->set_sidebar_menu([
    [
        'name' => 'Главная',
        'link' => '',
        'active' => true,
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
], 'admin.php');

function getCount($table, $where=null)
{
    global $pdo;
    $sql = 'SELECT COUNT(*) FROM `' . $table . '`'.
        ($where != null ? ' WHERE ' . $where : '');
    $stmt = $pdo->query($sql);
    return $stmt->fetchColumn();
}
?>
<h2 class="tac">Добро пожаловать в панель управления<br>JCat Radio Engine</h2>
<div class="panel panel-default">
    <table class="table table-striped table-bordered">
        <caption>Статистика сайта</caption>
        <tbody>
            <tr>
                <td>Зарегистрировано пользователей</td>
                <td><?= getCount('users') ?></td>
            </tr>
            <tr>
                <td>Из них активировало аккаунты</td>
                <td><?= getCount('users', '`status` = 1') ?></td>
            </tr>
            <tr>
                <td>Опубликовано новостей</td>
                <td><?= getCount('news', '`show` = 1') ?></td>
            </tr>
            <tr>
                <td>Добавленно программ</td>
                <td><?= getCount('programs') ?></td>
            </tr>
            <tr>
                <td>Добавленно эфиров</td>
                <td><?= getCount('schedule') ?></td>
            </tr>
        </tbody>
    </table>
</div>
<div class="panel panel-default hidden-xs">
  <div class="panel-heading">Статистика посещения сайта</div>
  <div class="panel-body">
    <div id="chart"></div>
    <table class="table table-striped table-bordered visits-table">
        <caption>Последние 10 посетителей</caption>
        <tbody>
            <tr>
                <th>Дата посещения</th>
                <th>Пользователь</th>
                <th>IP-адрес</th>
                <th>Браузер</th>
                <th>Операционная система</th>
                <th>Тип устройства</th>
            </tr>
        <?php
        $stmt = $pdo->query('SELECT * FROM `visit_stats` ORDER BY id DESC LIMIT 10');
        while ($row = $stmt->fetch()):
        $user_agent = json_decode($row->user_agent);
        ?>
            <tr>
                <td><?= date('d.m.Y', strtotime($row->date)) ?></td>
                <td><?= empty($row->user) ? 'Гость' : $row->user ?></td>
                <td><?= $row->ip ?></td>
                <td><?= $user_agent->browser ?></td>
                <td><?= $user_agent->platform ?></td>
                <td><?= $user_agent->device_type ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
  </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
google.charts.load('current', {'packages':['line']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {

  var data = new google.visualization.DataTable();
  data.addColumn('date');
  data.addColumn('number', 'Посетители');

  data.addRows([
    <?php
    $stmt = $pdo->query('SELECT `date`, COUNT(`date`) AS count FROM `visit_stats` GROUP BY `date`');
    while ($row = $stmt->fetch()) {
        echo '[new Date('.(strtotime($row->date)*1000).'), '.$row->count.'],';
    } ?>
  ]);

  var options = {
    hAxis: {
      format: 'dd.MM',
    },
    vAxis: {
      title: 'Количество посетителей'
    },
  };

  var chart = new google.charts.Line(document.getElementById('chart'));

  chart.draw(data, google.charts.Line.convertOptions(options));
}

window.onresize = function() {
    drawChart();
};
window.onload = function() {
    drawChart();
};
</script>