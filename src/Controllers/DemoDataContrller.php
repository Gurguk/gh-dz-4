<?php

namespace Controllers;

use Models\UniversityModel;

class DemoDataContrller
{
    private $university;

    public function __construct()
    {
        $this->university = new UniversityModel();
        $this->university->addDemo();
    }
}