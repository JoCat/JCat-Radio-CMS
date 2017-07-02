<?php
use JRC\Common\Components\SidebarMenu;

$menu = new SidebarMenu();
$menu->set_sidebar_menu([
    [
        'name' => 'Главная',
        'link' => '',
        'active' => true,
    ],
    [
        'name' => 'Новости',
        'link' => '/news',
    ],
    [
        'name' => 'Программы',
        'link' => '/programs',
    ],
    [
        'name' => 'Расписание',
        'link' => '/schedule',
    ],
    [
        'name' => 'Статические страницы',
        'link' => '/static',
    ],
], 'admin');
?>
<h2 class="tac">Добро пожаловать в панель управления<br>JCat Radio Engine</h2>
<div class="panel panel-default">
    <table class="table table-striped table-bordered">
        <caption>Статистика сайта</caption>
        <tbody>
            <tr>
                <td>Зарегистрировано пользователей</td>
                <td><?= $stats['users'] ?></td>
            </tr>
            <tr>
                <td>Из них активировало аккаунты</td>
                <td><?= $stats['users_active'] ?></td>
            </tr>
            <tr>
                <td>Опубликовано новостей</td>
                <td><?= $stats['news'] ?></td>
            </tr>
            <tr>
                <td>Добавленно программ</td>
                <td><?= $stats['programs'] ?></td>
            </tr>
            <tr>
                <td>Добавленно эфиров</td>
                <td><?= $stats['schedule'] ?></td>
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
        foreach ($visit_stats as $row):
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
        <?php endforeach; ?>
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
    foreach ($visit_table as $row) {
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