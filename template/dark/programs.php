<?php foreach ($programs as $row) : ?>
    <div class="custom-card">
        <div class="card-header"><?= $row['title'] ?></div>
        <div class="card-body">
            <div class="row">
                <div class="col-3">
                    <img class="mw-100 border border-dark rounded" src="<?= $row['image'] ?>" />
                </div>
                <div class="col-9">
                    <?= $row['description'] ?>
                </div>
            </div>
        </div>
        <div class="card-footer clearfix">
            <a class="float-right btn btn-outline-primary" href="<?= $row['link'] ?>">Подробнее</a>
        </div>
    </div>
<?php endforeach;
echo $pagination;
?>
