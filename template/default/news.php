<?php if (!empty($error)) {
    echo $error;
} else {
    foreach ($data as $row): ?>
    <div class="block">
      <b class="right"><?= $row['date'] ?></b>
      <b><?= $row['title'] ?></b>
      <hr>
      <p><?= $row['short_text'] ?></p>
      <a class="pull-right" href="<?= $row['link'] ?>">Подробнее</a>
      <div style="clear:both;"></div>
    </div>
    <?php endforeach;
    echo $pagination;
} ?>