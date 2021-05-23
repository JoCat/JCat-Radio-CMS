<?php
/*
=======================================
 JCat Radio CMS
---------------------------------------
 https://radio-cms.ru/
---------------------------------------
 Copyright (c) 2016-2021 Molchanov A.I.
=======================================
 Управление настройками сайта
=======================================
*/

include ENGINE_DIR . '/classes/purifier.php';
include ENGINE_DIR . '/classes/helpers.php';

$menu->set_sidebar_menu([
    [
        'name' => 'Общие настройки',
        'link' => 'main',
        'active' => true,
    ],
    [
        'name' => 'Настройка новостей',
        'link' => 'news',
    ],
    [
        'name' => 'Настройка программ',
        'link' => 'programs',
    ],
], '#', true);

if (!empty($_POST)) :
    ConfigLoader::save('config', $_POST);
    echo '<p>Настройки успешно сохранены</p>
    <a href="/admin.php?do=settings" class="btn btn-success">Вернутся назад</a>';
else : ?>
    <h1 class="tac">Настройки сайта</h1>
    <form id="form" action="" method="POST">
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="main">
                <div class="panel panel-default">
                    <table class="table table-striped table-bordered settings">
                        <tbody>
                            <tr>
                                <td>
                                    <div>Название сайта:</div>
                                    <small>Выводится в браузере</small>
                                </td>
                                <td>
                                    <input class="form-control" required type="text" name="title" value="<?= $config->title ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>Описание сайта:</div>
                                    <small>Краткое описание вашего сайта</small>
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="description" value="<?= $config->description ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>Ключевые слова:</div>
                                    <small>Введите через запятую основные ключевые слова для вашего сайта</small>
                                </td>
                                <td>
                                    <textarea style="height:60px;" class="form-control" name="keywords"><?= $config->keywords ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>Системный E-Mail адрес администратора:</div>
                                    <small>Введите E-Mail адрес администратора сайта. От имени данного адреса будут отправляться служебные сообщения скрипта, например уведомления пользователей о важных новостях и т.д. А также на этот адрес будут отправляться системные уведомления для администрации сайта, например, уведомления обратной связи и т.д.</small>
                                </td>
                                <td>
                                    <input class="form-control" type="email" name="admin_mail" value="<?= $config->admin_mail ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>Информация выводимая по умолчанию на главной странице:</div>
                                    <small>Выберите тип контента, который будет выводится на главной странице сайта по умолчанию. В случае если вы выбираете показ статической страницы, вам будет выводится контент шаблона index.tpl</small>
                                </td>
                                <td>
                                    <select required class="form-control" name="main_page">
                                        <option <?= $config->main_page == '1' ? 'selected' : ''; ?> value="1">Статическая страница</option>
                                        <option <?= $config->main_page == '2' ? 'selected' : ''; ?> value="2">Новости (страница "/news")</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>Шаблон сайта по умолчанию:</div>
                                    <small>Выберите шаблон, который будет использоваться на сайте</small>
                                </td>
                                <td>
                                    <select required class="form-control" name="tpl_dir">
                                        <?php foreach ($helpers->get_templates() as $value) : ?>
                                            <option <?= $config->tpl_dir == $value ? 'selected' : ''; ?> value="<?= $value ?>"><?= $value ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="news">
                <div class="panel panel-default">
                    <table class="table table-striped table-bordered settings">
                        <tbody>
                            <tr>
                                <td>
                                    <div>Количество новостей на странице:</div>
                                    <small>Количество кратких новостей, которое будет выводиться на страницу</small>
                                </td>
                                <td>
                                    <input class="form-control" required type="number" min="0" name="news_num" value="<?= $config->news_num ?>">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="programs">
                <div class="panel panel-default">
                    <table class="table table-striped table-bordered settings">
                        <tbody>
                            <tr>
                                <td>
                                    <div>Количество программ на странице:</div>
                                    <small>Количество программ, которое будет выводиться на страницу</small>
                                </td>
                                <td>
                                    <input class="form-control" required type="number" min="0" name="prog_num" value="<?= $config->prog_num ?>">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <button class="btn btn-success" type="submit">Сохранить</button>
    </form>
<?php endif; ?>
