<?php foreach ($news as $row): ?>
  <div class="block clearfix">
    <b class="right"><?= $row['date'] ?></b>
    <b><?= $row['title'] ?></b>
    <hr>
    <p><?= $row['short_text'] ?></p>
    <hr>
    <a class="pull-right" href="<?= $row['link'] ?>">Подробнее</a>
  </div>
  <?php endforeach;
  echo $pagination;
?>