<?php
use JRC\Common\Components\SidebarMenu;
use JRC\Core\Helpers;

$menu = new SidebarMenu();
$menu->set_sidebar_menu([
    [
        'name' => 'Главная',
        'link' => '',
    ],
    [
        'name' => 'Новости',
        'link' => '/news',
        'active' => true,
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
<div class="row mb10">
  <div class="col-xs-2">
    <a class="btn btn-success" href="/admin/news/create" role="button">Добавить новость</a>
  </div>
  <!-- <div class="col-xs-4">
    <div class="input-group">
      <input type="text" class="form-control" placeholder="Поиск по названию...">
      <span class="input-group-btn">
        <button class="btn btn-default" type="button">
          <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
        </button>
      </span>
    </div>
  </div> -->
</div>
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
    <?php if (empty($news)): ?>
      <tr>
        <td colspan="5">Новости не найдены</td>
      </tr>
    <?php else: ?>
      <?php foreach ($news as $post): ?>
      <tr>
        <td><?= Helpers::get_date($post->date) ?></td>
        <td><?= Helpers::text_cut($post->title, 25) ?></td>
        <td><?= Helpers::text_cut(strip_tags($post->short_text), 80) ?></td>
        <td width="50" align="center"><a href="/admin/news/update/<?= $post->id ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true" title="Изменить"></a></span></td>
        <td width="50" align="center"><a href="/admin/news/delete/<?= $post->id ?>"><span class="glyphicon glyphicon-remove" aria-hidden="true" title="Удалить"></a></span></td>
      </tr>
      <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
  </table>
</div>