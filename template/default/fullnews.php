<div class="panel panel-default">
    <div class="panel-heading">
      <?= $data['title'] ?>
      <span class="pull-right"><?= $data['date'] ?></span>
    </div>
    <div class="panel-body">
      <?= $data['full_text'] ?>
    </div>
    <div class="panel-footer">
      Автор: <b><?= $data['author'] ?></b>
    </div>
</div>

<div id="vk_comments"></div>
<script type="text/javascript">
VK.Widgets.Comments("vk_comments", {limit: 10, attach: "*"});
</script>