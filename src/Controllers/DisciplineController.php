<?php

namespace Controllers;

use Models\DisciplineModel;
use Views\Render;

class DisciplineController
{
    private $discipline;

    private $view;

    public function __construct()
    {
        $this->discipline = new DisciplineModel();
        $this->view = new Render();
    }

    public function actionIndex()
    {

    }
}