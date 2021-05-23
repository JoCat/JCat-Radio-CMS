<script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<h1 class="text-center">Редактировать программу</h1>
<form action="" method="POST" enctype="multipart/form-data">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">Главное</a></li>
        <li role="presentation"><a href="#meta" aria-controls="meta" role="tab" data-toggle="tab">Адрес и Мета-теги</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="general">
            <div class="form-group">
                <label for="title">Заголовок новости</label>
                <input type="text" required class="form-control" name="title" id="title" value="<?= $programs->title ?>">
            </div>
            <div class="form-group">
                <label for="description">Описание</label>
                <textarea name="description" id="description"><?= $programs->description ?></textarea>
            </div>
            <?php if (empty($programs->image)) : ?>
                <div class="form-group">
                    <label for="image">Загрузить изображение</label>
                    <input type="file" id="image" name="image">
                    <p class="help-block">Рекомендуемый размер 200x150px.</p>
                </div>
            <?php else : ?>
                <div class="form-group">
                    <label for="old_image">Изображение</label>
                    <input type="hidden" id="old_image" name="old_image" value="<?= $programs->image ?>">
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="thumbnail">
                                <img src="/uploads/images/programs/<?= $programs->image ?>" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="image">Изменить изображение</label>
                    <input type="file" id="image" name="image">
                    <p class="help-block">Рекомендуемый размер 200x150px.</p>
                </div>
            <?php endif; ?>
            <div class="checkbox">
                <label>
                    <input type="hidden" name="show" value="0">
                    <input type="checkbox" name="show" value="1" <?php if ($programs->show) echo " checked"; ?>>Отображать программу на сайте
                </label>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="meta">
            <div class="form-group">
                <label for="alt_name">Ссылка на страницу</label>
                <input type="text" class="form-control" name="alt_name" id="alt_name" value="<?= $programs->alt_name ?>">
                <p class="help-block">Оставьте поле пустым для автоматической генерации адреса</p>
            </div>
            <div class="form-group">
                <label for="seo_title">Заголовок страницы</label>
                <input type="text" class="form-control" name="seo_title" id="seo_title" value="<?= $programs->seo_title ?>">
            </div>
            <div class="form-group">
                <label for="seo_description">SEO Описание</label>
                <textarea class="form-control" name="seo_description" id="seo_description"><?= $programs->seo_description ?></textarea>
            </div>
            <div class="form-group">
                <label for="seo_keywords">Ключевые слова</label>
                <input type="text" class="form-control" name="seo_keywords" id="seo_keywords" value="<?= $programs->seo_keywords ?>">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-success" name="submit">Сохранить</button>
</form>
<script>
    CKEDITOR.replace('description');
    document.addEventListener("DOMContentLoaded", function() {
        $('#alt-title').on('keypress', function(e) {
            var key = e.keyCode || e.charCode;
            var char = String.fromCharCode(key);
            var reg = /[a-z0-9-]/;
            return 8 === key || reg.test(char);
        });
    });
</script>
