<h1 class="tac">Редактирование группы</h1>
<form action="" method="POST">
  <div class="form-group">
    <label for="name">Название</label>
    <input required type="text" class="form-control" name="name" id="name" value="<?= $data->name ?>">
  </div>
  <div class="checkbox">
    <label>
      <input type="hidden" name="is_admin" value="0">
      <input type="checkbox" name="is_admin" <?= $data->is_admin ? 'checked' : '' ?> value="1"> Доступ в админпанель
    </label>
  </div>
  <button type="submit" class="btn btn-success" name="submit">Сохранить</button>
</form>