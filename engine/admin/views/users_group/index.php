<div class="row mb10">
  <div class="col-xs-2">
    <a class="btn btn-success" href="/admin.php?do=users_group&create" role="button">Добавить группу</a>
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
        <th>ID</th>
        <th>Название</th>
        <th colspan="2" width="100" align="center">Управление</th>
      </tr>
    </thead>
    <tbody>
    <?php if (empty($data)): ?>
      <tr>
        <td colspan="4">Группы не найдены</td>
      </tr>
    <?php else: ?>
      <?php foreach ($data as $row): ?>
      <tr>
        <td><?= $row->id ?></td>
        <td><?= $row->name ?></td>
        <td width="50" align="center"><a href="/admin.php?do=users_group&edit=<?= $row->id ?>"><span class="glyphicon glyphicon-edit" aria-hidden="true" title="Изменить"></a></span></td>
        <td width="50" align="center"><a href="/admin.php?do=users_group&delete=<?= $row->id ?>"><span class="glyphicon glyphicon-remove" aria-hidden="true" title="Удалить"></a></span></td>
      </tr>
      <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
  </table>
</div>