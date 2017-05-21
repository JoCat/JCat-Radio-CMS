<?php if (!empty($error)) {
    echo $error;
} else {
    foreach ($data as $row): ?>
    <div class="block">
      <img class="left" style="margin-right:5px;" src="<?= $row['image'] ?>"/>
      <a href="<?= $row['link'] ?>"><h3><?= $row['title'] ?></h3></a>
      <p><?= $row['description'] ?></p>
      <div style="clear:both;"></div>
    </div>
    <?php endforeach;
    echo $pagination;
} ?>