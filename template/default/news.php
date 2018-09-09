<?php foreach ($news as $row): ?>
  <div class="panel panel-default">
    <div class="panel-heading">
      <?= $row['title'] ?>
      <span class="pull-right"><?= $row['date'] ?></span>
    </div>
    <div class="panel-body">
      <?= $row['short_text'] ?>
    </div>
    <div class="panel-footer clearfix">
      <a class="pull-right" href="<?= $row['link'] ?>">Подробнее</a>
    </div>
  </div>
  <?php endforeach;
  echo $pagination;
?>

