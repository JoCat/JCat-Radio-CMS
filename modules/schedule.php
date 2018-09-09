<?php

include_once (ENGINE_DIR . '/classes/config_loader.php');
include_once (ENGINE_DIR . '/classes/db_connect.php');
include_once (ENGINE_DIR . '/classes/helpers.php');

$config = ConfigLoader::load('config');
$db_config = ConfigLoader::load('db_config');

$stmt = $pdo->prepare('SELECT * FROM `schedule` JOIN `programs` ON schedule.program_id = programs.id WHERE schedule.day = :day AND schedule.show = 1 ORDER BY schedule.start_time ASC');
$stmt->execute(['day' => strtolower(date("l"))]);
$data = $stmt->fetchAll();

if (!empty($data)) {
    foreach ($data as $row) :
        $image = empty($row->image) ?
            '/template/' . $config->tpl_dir . '/images/no_image.png' :
            '/uploads/images/programs/' . $row->image;
?>
        <div class="media">
          <div class="media-left">
            <a href="<?= '/programs/' . $row->alt_name ?>">
              <img class="media-object" style="width: 100px;" src="<?= $image ?>" alt="<?= $row->title ?>">
            </a>
          </div>
          <div class="media-body">
            <h4 class="media-heading"><?= $row->title ?></h4>
            <?= $helpers->get_time($row->start_time) ?> - <?= $helpers->get_time($row->end_time) ?>
          </div>
        </div>
<?php endforeach;
} else {
    echo "На сегодня эфиров нет";
}
