<div class="custom-card">
    <div class="card-header"><?= $data['title'] ?></div>
    <div class="card-body">
        <div class="row">
            <div class="col-3">
                <img class="mw-100 border border-dark rounded" src="<?= $data['image'] ?>" />
            </div>
            <div class="col-9">
                <?= $data['description'] ?>
            </div>
        </div>
    </div>
</div>
