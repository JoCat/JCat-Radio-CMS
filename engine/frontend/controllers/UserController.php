<?php

namespace JRC\Frontend\Controllers;

use JRC\Frontend\Models\Users;
use JRC\Core\Exceptions\NotFoundException;
/**
* 
*/
class UserController extends \JRC\Core\Controller
{
    public function actionView($username)
    {
        $user = Users::find([
            'conditions' => [
                'login =?', $username
            ],
            'select' => '`users`.login, `users`.image, `user_groups`.name',
            'joins' => 'JOIN `user_groups` ON users.usergroup_id = user_groups.id'
        ]);

        $user->username = $user->login;
        $user->usergroup = $user->name;
        $user->image = empty($user->image) ?
            '/template/' . 'default' /*$config->tpl_dir*/ . '/images/no_avatar.png' :
            '/uploads/images/users/' . $user->image;

        $this->render('userpage', [
            'user' => $user
        ]);
    }
}