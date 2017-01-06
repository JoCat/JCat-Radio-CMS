<?php
/*
=====================================
 JCat Radio Engine
-------------------------------------
 http://radiocms.tk
-------------------------------------
 Copyright (c) 2016 Molchanov A.I.
=====================================
 Вывод ведущих
=====================================
*/
if (!defined ('JRE_KEY')) die ("Hacking attempt!");
include(ENGINE_DIR . '/data/db_config.php');
include(ENGINE_DIR . '/classes/db_connect.php');

$show = isset($_GET['show']) ? $_GET['show'] : false;
    switch($show)
    {
        case 'all':
            $page_title = 'Ведущие';
            $stmt = $pdo->query('SELECT * FROM jre_rj ORDER BY id ASC');
            while($row = $stmt->fetch()){
                $tpl->set("{name}", $row["name"]);
                $tpl->set("{description}", $row["description"]);
                if ($row["pic"]) {
                    $tpl->set("{pic}", '/pages/images/rj/'.$row["pic"]);
                }else {
                    $tpl->set("{pic}", '/pages/images/no_image.png');
                }
                $content .= $tpl->showmodule("rjblock.tpl");
            }
            if (empty($content)){
                $content = '<div class="error-alert">
                <b>Внимание! Обнаружена ошибка</b><br>
                На данный момент у нас нет ведуших или они не указаны.
                </div>';
            }
            $tpl->set("{content}", $content);
            break;

        /*
        case 'rj':
            $page_title = $row["name"];
            //Temporarily not working
            $tpl->set("{content}", $tpl->showmodule("rjpage.tpl"));
        break;
        */
    }
?>