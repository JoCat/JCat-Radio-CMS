<?php foreach ($programs as $row): ?>
  <div class="block">
    <div class="row">
      <div class="col-xs-3">
        <img class="left img-responsive" src="<?= $row['image'] ?>"/>
      </div>
      <div class="col-xs-9">
        <a href="<?= $row['link'] ?>"><h3><?= $row['title'] ?></h3></a>
        <p><?= $row['description'] ?></p>
      </div>
    </div>
  </div>
  <?php endforeach;
  echo $pagination;
?>