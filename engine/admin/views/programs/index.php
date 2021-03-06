<div class="row mb10">
  <div class="col-xs-2">
    <a class="btn btn-success" href="/admin.php?do=programs&create" role="button">Добавить программу</a>
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
        <th>Название</th>
        <th>Описание</th>
        <th colspan="2" width="100" align="center">Управление</th>
      </tr>
    </thead>
    <tbody>
    <?php if (empty($data)): ?>
      <tr>
        <td colspan="4">Программы не найдены</td>
      </tr>
    <?php else: ?>
      <?php foreach ($data as $row): ?>
      <tr>
        <td><?= $helpers->text_cut($row->title, 25) ?></td>
        <td><?= $helpers->text_cut(strip_tags($row->description), 100) ?></td>
        <td width="50" align="center"><a href="/admin.php?do=programs&update=<?= $row->id ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true" title="Изменить"></a></span></td>
        <td width="50" align="center"><a href="/admin.php?do=programs&delete=<?= $row->id ?>"><span class="glyphicon glyphicon-remove" aria-hidden="true" title="Удалить"></a></span></td>
      </tr>
      <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
  </table>
</div>