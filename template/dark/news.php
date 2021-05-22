<?php foreach ($news as $row) : ?>
    <div class="custom-card">
        <div class="card-header">
            <?= $row['title'] ?>
            <span class="float-right"><?= $row['date'] ?></span>
        </div>
        <div class="card-body">
            <?= $row['short_text'] ?>
        </div>
        <div class="card-footer clearfix">
            <a class="float-right btn btn-primary" href="<?= $row['link'] ?>">Подробнее</a>
        </div>
    </div>
<?php endforeach;
echo $pagination;
?>
