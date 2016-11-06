<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 06.11.16
 * Time: 17:30
 */

namespace Controllers;

use Models\StudentModel;

class StudentController
{
    private $student;

    public function __construct()
    {
        $this->student = new StudentModel();
    }



}