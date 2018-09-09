<?php
/*
=======================================
 JCat Radio Engine
---------------------------------------
 *site*
---------------------------------------
 Copyright (c) 2016-2017 Molchanov A.I.
=======================================
 Админпанель
=======================================
*/
if (!defined('JRE_KEY')) die ("Hacking attempt!");
include (ENGINE_DIR . '/classes/helpers.php');
?>
<style>
aside {display:none;}
.content {margin-left:0;}
</style>

<div class="page-header">
<h1 class="text-center">Панель управления вещанием</h1>
</div>
<div class="row">
    <div class="col-xs-4">
        <div class="well in-air">
            <h1 class="text-center">В ЭФИРЕ</h1>
        </div>
        <div class="well text-success">
            <h2 class="text-center">Время: <span id="time">12:43</span></h2>
            <h3 class="text-center">Продолжительность эфира: 0:27:44</h3>
        </div>
        <div class="well">
            Сейчас играет: %%%%% <br>
            Слушателей: 123 <br>
            и т.д.
        </div>
    </div>
    <div class="col-xs-8">
        <div class="panel panel-default">
            <div class="panel-heading"><h2>Чат</h2></div>
            <div class="panel-body chat">
                <div class="msg clearfix">
                    <div class="img"></div>
                    <div class="text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc risus metus, sodales non placerat vel, suscipit in libero.
                    </div>
                </div>
                <div class="msg clearfix">
                    <div class="img"></div>
                    <div class="text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc risus metus, sodales non placerat vel, suscipit in libero.
                    </div>
                </div>
                <div class="msg right clearfix">
                    <div class="img"></div>
                    <div class="text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc risus metus, sodales non placerat vel, suscipit in libero.
                    </div>
                </div>
                <div class="msg clearfix">
                    <div class="img"></div>
                    <div class="text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc risus metus, sodales non placerat vel, suscipit in libero.
                    </div>
                </div>
            </div>
                <div class="panel-footer chat-input">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Введите сообщение...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Отправить</button>
                        </span>
                    </div>
                </div>
        </div>
    </div>
</div>
<button type="button" class="btn btn-default">Завершить эфир</button>
<button type="button" class="btn btn-default">Кнопка</button>
<button type="button" class="btn btn-default">Ещё кнопка</button>
<button type="button" class="btn btn-default">Больше кнопок богу кнопок</button>

<script>
    var date = new Date();
    document.getElementById('time').innerHTML =
        date.getHours() + ':' +
        ((String(date.getMinutes()).length <= 1) ? 0 : '')
        + date.getMinutes();
</script>