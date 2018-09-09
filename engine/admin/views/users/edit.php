<h1 class="tac">Редактирование пользователя</h1>
<form action="" method="POST">
  <div class="form-group">
    <label for="login">Логин</label>
    <input required type="text" class="form-control" name="login" id="login" value="<?= $data->login ?>">
  </div>
  <div class="form-group">
    <label for="password">Задать новый пароль</label>
    <input type="text" class="form-control" name="password" id="password">
  </div>
  <div class="form-group">
    <label for="email">Эл. почта</label>
    <input required type="text" class="form-control" name="email" id="email" value="<?= $data->email ?>">
  </div>
  <div class="form-group">
    <label for="user_group">Группа пользователя</label>
    <select class="form-control" required name="user_group" id="user_group">
      <option value="" hidden disabled selected>Выберите группу</option>
      <?php foreach ($usergroups as $value): ?>
      <option value="<?= $value->id ?>"<?php if ($value->id == $data->usergroup_id) echo ' selected'; ?>><?= $value->name ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <button type="submit" class="btn btn-success" name="submit">Сохранить</button>
</form>