<?php

namespace JRC\Frontend\Controllers;

use JRC\Common\Models\User;

class UserController extends \JRC\Core\Controller
{
    public function actionView($username)
    {
        $user = User::find_by_login($username);

        $user->image = empty($user->image) ?
            '/images/no_avatar.png' :
            '/uploads/images/users/' . $user->image;

        $this->render('view', compact('user'));
    }
}