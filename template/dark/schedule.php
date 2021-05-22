<?php foreach ($schedule as $key => $row) : ?>
    <div class="custom-card">
        <div class="card-header"><?= $days[$key] ?></div>
        <ul class="list-group list-group-flush">
            <?php foreach ($row as $value) : ?>
                <li class="list-group-item bg-custom">
                    <span><?= $value['start_time'] ?> - <?= $value['end_time'] ?></span>
                    <span><?= $value['title'] ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endforeach; ?>
