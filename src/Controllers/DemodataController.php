<?php

namespace Controllers;

use Models\UniversityRepository;
use Models\DepartmentRepository;
use Models\StudentRepository;
use Views\Render;

class DemodataController
{
    private $university;

    private $department;

    private $student;

    private $view;

    public function __construct()
    {
        $this->university = new UniversityRepository();
        $this->department = new DepartmentRepository();
        $this->student = new StudentRepository();
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
