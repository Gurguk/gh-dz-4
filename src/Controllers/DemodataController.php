<?php

namespace Controllers;

use Models\UniversityModel;
use Models\DepartmentModel;
use Models\StudentModel;
use Views\Render;

class DemodataController
{
    private $university;

    private $department;

    private $student;

    private $view;

    public function __construct()
    {
        $this->university = new UniversityModel();
        $this->department = new DepartmentModel();
        $this->student = new StudentModel();
        $this->view = new Render();
    }

    public function actionIndex()
    {
        $data = array($this->university->init(), $this->department->init(), $this->student->init());

        return $this->view->display('demodata', array('demodata' => $data));
    }

    public function actionDemo()
    {
        $data = array($this->university->addDemo(), $this->department->addDemo(), $this->student->addDemo());

        return $this->view->display('demodata', array('demodata' => $data));
    }
}
