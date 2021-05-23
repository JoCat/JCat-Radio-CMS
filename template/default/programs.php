<?php foreach ($programs as $row) : ?>
    <div class="panel panel-default">
        <div class="panel-heading"><?= $row['title'] ?></div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-3">
                    <img class="left img-responsive" src="<?= $row['image'] ?>" />
                </div>
                <div class="col-xs-9">
                    <?= $row['description'] ?>
                </div>
            </div>
        </div>
        <div class="panel-footer clearfix">
            <a class="pull-right" href="<?= $row['link'] ?>">Подробнее</a>
        </div>
    </div>
<?php endforeach;
echo $pagination;
?>
