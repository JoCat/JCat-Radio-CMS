<div class="block userpage clearfix">
    <div class="pull-left">
        <img src="<?= $user->image ?>" class="img-circle user-img">
    </div>
    <div class="pull-left info">
        <h1><?= $user->login ?></h1>
        <h2>Группа: <?= $user->users_group->name ?></h2>
    </div>
</div>