<?php foreach ($news as $post): ?>
    <div class="block clearfix">
      <b class="right"><?= $post->date ?></b>
      <b><?= $post->title ?></b>
      <hr>
      <p><?= $post->short_text ?></p>
      <hr>
      <a class="pull-right" href="/news/view/<?= $post->id.'-'.$post->alt_name ?>">Подробнее</a>
    </div>
    <?php endforeach;
    //echo $pagination;
?>