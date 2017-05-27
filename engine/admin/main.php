<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://radiocms.tk
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Админпанель
=====================================
*/
if (!defined('JRE_KEY')) die("Hacking attempt!");
include(ENGINE_DIR . '/data/db_config.php');
include(ENGINE_DIR . '/classes/db_connect.php');
include(ENGINE_DIR . '/admin/head.html');
?>
<h2>Добро пожаловать в панель управления JCat Radio Engine</h2>
<?php
$stmt = $pdo->prepare('SELECT * FROM `jre_widgets` ORDER BY `id` LIMIT 0,9');
$stmt->execute();
?>
<div id="modal_form">
    <span id="modal_close">X</span>
    <div id="title"></div>
    <hr>
    <div id="text-block">
        <div id="text"></div>
    </div>
</div>
<div id="overlay"></div>
<?php
$i = 0;
while($row = $stmt->fetch()): ?>
<div id="w<?= $i ?>" class="widget">
    <div class="title"><?= $row["name"] ?></div>
    <hr>
    <div class="text"><?= str_replace(["\r\n", "\n", "\r"],'<br>',$row["text"]) ?></div>
    <button onclick="modal(<?= $i++ ?>)" style="height:40px;margin:0;" class="button">Подробнее</button>
</div>
<?php endwhile;
include(ENGINE_DIR . '/admin/footer.html');
?>
