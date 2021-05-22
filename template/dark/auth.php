<div class="custom-card" style="padding: 15px;">
    <h1 class="text-center">Авторизация</h1>
    <?php if (!empty($helpers->msg)) echo $helpers->msg; ?>
    <form class="m-auto col-12 col-lg-6" method="POST">
        <div class="form-group">
            <label for="login">Логин</label>
            <input type="text" class="form-control" required placeholder="Введите логин" name="login" id="login">
        </div>
        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" class="form-control" required placeholder="Введите пароль" name="pass" id="password">
        </div>
        <button type="submit" class="btn btn-primary my-3">Войти</button>
    </form>
</div>
