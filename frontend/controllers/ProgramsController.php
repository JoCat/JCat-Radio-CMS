<?php

namespace JRC\Frontend\Controllers;

use JRC\Common\Models\Programs;
use JRC\Core\Exceptions\NotFoundException;
/**
* 
*/
class ProgramsController extends \JRC\Core\Controller
{
    public function actionIndex()
    {
        $programs = Programs::all([
            'conditions' => [
                '`show` =?', 1
            ],
            'limit' => 10,
            'offset' => 0
        ]);

        foreach ($programs as $value) {
            $value->link = '/programs/'. $value->alt_name;
            $value->image = empty($value->image) ?
                '/images/no_image.png' :
                '/uploads/images/programs/' . $value->image;
        }

        $this->render('programs', [
            'programs' => $programs
        ]);
    }

    public function actionView($link)
    {
        $program = Programs::find([
            'conditions' => [
                'alt_name =?', $link
            ],
        ]);

        $program->link = '/programs/'. $program->alt_name;
        $program->image = empty($program->image) ?
            '/images/no_image.png' :
            '/uploads/images/programs/' . $program->image;

        if (empty($program)) {
            throw new NotFoundException("Program not found");
        }

        $this->render('fullprog', [
            'program' => $program
        ]);
    }
}