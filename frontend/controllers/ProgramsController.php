<?php

namespace JRC\Frontend\Controllers;

use JRC\Common\Models\Program;
use JRC\Core\Exceptions\NotFoundException;

class ProgramsController extends \JRC\Core\Controller
{
    public function actionIndex()
    {
        $programs = Program::find_all_by_show(1, [
            'limit' => 10,
            'offset' => 0
        ]);

        foreach ($programs as $value) {
            $value->link = '/programs/'. $value->alt_name;
            $value->image = empty($value->image) ?
                '/images/no_image.png' :
                '/uploads/images/programs/' . $value->image;
        }

        $this->render('index', compact('programs'));
    }

    public function actionView($link)
    {
        $program = Program::find_by_alt_name($link);

        $program->image = empty($program->image) ?
            '/images/no_image.png' :
            '/uploads/images/programs/' . $program->image;

        if (empty($program)) {
            throw new NotFoundException("Program not found");
        }

        $this->render('view', compact('program'));
    }
}