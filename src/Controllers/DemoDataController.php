<?php

namespace Controllers;

use Models\UniversityModel;
use Models\DepartmentModel;

class DemoDataContrller
{
    private $university;

    private $department;

    public function __construct()
    {
        $this->university = new UniversityModel();
        $this->university->addDemo();
        $this->department = new DepartmentModel();
        $this->department->addDemo();
    }
}