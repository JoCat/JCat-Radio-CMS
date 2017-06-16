<script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<h1 class="tac">Изменить статическую страницу</h1>
<form action="" method="POST">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">Главное</a></li>
    <li role="presentation"><a href="#meta" aria-controls="meta" role="tab" data-toggle="tab">Мета-теги</a></li>
  </ul>
  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="general">
      <div class="form-group">
        <label for="url">Ссылка на страницу</label>
        <input type="text" required class="form-control" name="url" id="url" value="<?= $static->url ?>">
      </div>
      <div class="form-group">
        <label for="content">Контент страницы</label>
        <textarea name="content" id="content"><?= $static->content ?></textarea>
      </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="meta">
      <div class="form-group">
        <label for="seo_title">Заголовок страницы</label>
        <input type="text" class="form-control" name="seo_title" id="seo_title" value="<?= $static->seo_title ?>">
      </div>
      <div class="form-group">
        <label for="seo_description">SEO Описание</label>
        <textarea class="form-control" name="seo_description" id="seo_description"><?= $static->seo_description ?></textarea>
      </div>
      <div class="form-group">
        <label for="seo_keywords">Ключевые слова</label>
        <input type="text" class="form-control" name="seo_keywords" id="seo_keywords" value="<?= $static->seo_keywords ?>">
      </div>
    </div>
  </div>
  <button type="submit" class="btn btn-success" name="submit">Сохранить</button>
</form>
<script>
  CKEDITOR.replace('content');
  document.addEventListener("DOMContentLoaded", function() { 
    $('#url').on('keypress', function (e) {
        var key = e.keyCode || e.charCode;
        var char = String.fromCharCode(key);
        var reg = /[a-z0-9-]/;
        return 8 === key || reg.test(char);
    });
  });
</script>