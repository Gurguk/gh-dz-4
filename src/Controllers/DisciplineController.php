<?php

namespace Controllers;

use Repository\DisciplineRepository;
use Views\Render;

class DisciplineController
{
    private $discipline;

    private $view;

    public function __construct()
    {
        $this->discipline = new DisciplineRepository();
        $this->view = new Render();
    }

    public function actionIndex()
    {
    }
}
