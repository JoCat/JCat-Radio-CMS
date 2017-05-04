<?php if (!empty($error)) {
    echo $error;
} else {
    foreach ($data as $key => $row): ?>
	<div class="day-block">
	  <div class="day"><?= $days[$key] ?></div>
	  <?php foreach ($row as $value): ?>
	  	<div class="block">
		  <span><?= $helpers->get_time($value['start_time']) ?> - <?= $helpers->get_time($value['end_time']) ?></span>
		  <span><?= $value['title'] ?></span>
		</div>
	  <?php endforeach; ?>
	</div>
	<?php endforeach;
} ?>