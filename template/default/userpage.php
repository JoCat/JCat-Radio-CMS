<?php if (!empty($error)): ?>
    <?= $error ?>
<? else: ?>
    <div class="userpage">
      <img src="<?= $data['image'] ?>" class="img-circle user-img">
      <h1><?= $data['username'] ?></h1>
      <h2>Группа: <?= $data['usergroup'] ?></h2>
    </div>
<?php endif; ?>