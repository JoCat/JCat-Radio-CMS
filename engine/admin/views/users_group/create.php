<h1 class="tac">Добавить группу</h1>
<form action="" method="POST">
  <div class="form-group">
    <label for="name">Название</label>
    <input required type="text" class="form-control" name="name" id="name">
  </div>
  <div class="checkbox">
    <label>
      <input type="hidden" name="is_admin" value="0">
      <input type="checkbox" name="is_admin" value="1"> Доступ в админпанель
    </label>
  </div>
  <div class="checkbox">
    <label>
      <input type="hidden" name="news_edit" value="0">
      <input type="checkbox" name="news_edit" value="1"> Редактирование новостей
    </label>
  </div>
  <div class="checkbox">
    <label>
      <input type="hidden" name="programs_edit" value="0">
      <input type="checkbox" name="programs_edit" value="1"> Редактирование программ
    </label>
  </div>
  <div class="checkbox">
    <label>
      <input type="hidden" name="schedule_edit" value="0">
      <input type="checkbox" name="schedule_edit" value="1"> Редактирование расписания
    </label>
  </div>
  <div class="checkbox">
    <label>
      <input type="hidden" name="page_edit" value="0">
      <input type="checkbox" name="page_edit" value="1"> Редактирование статических страниц
    </label>
  </div>
  <div class="checkbox">
    <label>
      <input type="hidden" name="users_view" value="0">
      <input type="checkbox" name="users_view" value="1"> Просмотр списка пользователей
    </label>
  </div>
  <div class="checkbox">
    <label>
      <input type="hidden" name="users_edit" value="0">
      <input type="checkbox" name="users_edit" value="1"> Редактирование пользователей
    </label>
  </div>
  <div class="checkbox">
    <label>
      <input type="hidden" name="groups_edit" value="0">
      <input type="checkbox" name="groups_edit" value="1"> Редактирование пользователей
    </label>
  </div>
  <button type="submit" class="btn btn-success" name="submit">Добавить</button>
</form>