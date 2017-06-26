<div class="block">
    <b class="right"><?= $post->date ?></b>
    <h1><?= $post->title ?></h1><hr>
    <div><?= empty($post->full_text) ? $post->short_text : $post->full_text ?></div>
    <hr>
    Автор: <a href="<?= '/user/view/' . $post->login ?>"><b><?= $post->login ?></b></a>
</div>