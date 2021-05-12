<?php foreach ($schedule as $row): ?>
<div class="day-block">
  <div class="day"><?= $row->day ?></div>
  <?php foreach ($row->data as $value): ?>
    <div class="block">
      <span><?= $value->start_time ?> - <?= $value->end_time ?></span>
      <a href="<?= '/programs/'. $value->alt_name ?>"><?= $value->title ?></a>
    </div>
  <?php endforeach; ?>
</div>
<?php endforeach;
?>