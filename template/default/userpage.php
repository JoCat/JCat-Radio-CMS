<?php if (!empty($error)): ?>
    <?= $error ?>
<? else: ?>
    <div>
      <img src="<?= $data['image'] ?>" class="img-circle" style="width: 100px; height: 100px; margin: 5px;">
      <h1><?= $data['username'] ?></h1>
      <h2>Группа: <?= $data['usergroup'] ?></h2>
    </div>
<?php endif; ?>