<?php foreach ($schedule as $key => $row) : ?>
    <div class="day-block">
        <div class="day"><?= $days[$key] ?></div>
        <?php foreach ($row as $value) : ?>
            <div class="block">
                <span><?= $value['start_time'] ?> - <?= $value['end_time'] ?></span>
                <span><?= $value['title'] ?></span>
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>
