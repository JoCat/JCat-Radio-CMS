<?php foreach ($programs as $post): ?>
  <div class="block">
    <div class="row">
      <div class="col-xs-3">
        <img class="left img-responsive" src="<?= $post->image ?>"/>
      </div>
      <div class="col-xs-9">
        <a href="<?= $post->link ?>"><h3><?= $post->title ?></h3></a>
        <p><?= $post->description ?></p>
      </div>
    </div>
  </div>
  <?php endforeach;
  //echo $pagination;
?>