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

<!-- Put this script tag to the <head> of your page -->
<script src="//vk.com/js/api/openapi.js?154"></script>
<script type="text/javascript">
  VK.init({apiId: 6470590, onlyWidgets: true});
</script>

<!-- Put this div tag to the place, where the Comments block will be -->
<div id="vk_comments"></div>
<script type="text/javascript">
VK.Widgets.Comments("vk_comments", {limit: 10, attach: "*"});
</script>