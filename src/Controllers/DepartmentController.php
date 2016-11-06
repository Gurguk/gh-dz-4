<?php

namespace Controllers;


use Models\DepartmentModel;

class DepartmentController
{
    private $department;

    public function __construct()
    {
        $this->department = new DepartmentModel();
    }

    public function actionIndex(){

    }

}