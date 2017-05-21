<h1 class="tac">Изменить эфир</h1>
<form action="" method="POST">
  <div class="form-group">
    <label for="program">Название программы</label>
    <select class="form-control" required name="program" id="program">
      <option value="" hidden disabled selected>Выберите программу</option>
      <?php foreach ($programs as $value): ?>
      <option value="<?= $value['id'] ?>"<?php if ($value['id'] == $schedule['program_id']) echo ' selected'; ?>><?= $value['title'] ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="form-group">
    <label for="start_time">Время начала эфира</label>
    <div class="input-group clockpicker">
        <input required type="text" class="form-control" name="start_time" id="start_time" value="<?= $helpers->get_time($schedule['start_time']) ?>">
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-time"></span>
        </span>
    </div>
  </div>
  <div class="form-group">
    <label for="end_time">Время завершения эфира</label>
    <div class="input-group clockpicker">
        <input required type="text" class="form-control" name="end_time" id="end_time" value="<?= $helpers->get_time($schedule['end_time']) ?>">
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-time"></span>
        </span>
    </div>
  </div>
  <div class="form-group">
    <label for="day">День эфира</label>
    <select class="form-control" required name="day" id="day">
      <?php foreach ($days as $key => $value): ?>
      <option value="<?= $key ?>" <?php if ($key == $schedule['day']) echo ' selected'; ?>><?= $value ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="checkbox">
    <label>
      <input type="hidden" name="show" value="0">
      <input type="checkbox" name="show" value="1"<?php if ($schedule['show']) echo " checked"; ?>>Отображать эфир на сайте
    </label>
  </div>
  <button type="submit" class="btn btn-success" name="submit">Сохранить</button>
</form>
<script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function() { 
    $('.clockpicker').clockpicker({autoclose: true});
  });
</script>