<h1 class="title">Авторизация</h1>
<form class="form-horizontal" action="" method="POST">
  <div class="form-group">
    <label for="login" class="col-xs-2 control-label">Логин</label>
    <div class="col-xs-10 col-sm-8">
      <input class="form-control" required placeholder="Введите логин" type="text" name="login" id="login">
    </div>
  </div>
  <div class="form-group">
    <label for="password" class="col-xs-2 control-label">Пароль</label>
    <div class="col-xs-10 col-sm-8">
      <input class="form-control" required placeholder="Введите пароль" type="password" name="pass" id="password">
    </div>
  </div>
  <div class="form-group">
    <div class="col-xs-offset-2 col-xs-10">
      <button type="submit" class="btn btn-default">Войти</button>
      <a href="/admin.php?do=lostpassword">Забыли пароль?</a>
    </div>
  </div>
</form>