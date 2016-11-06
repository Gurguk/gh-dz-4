<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 06.11.16
 * Time: 21:15
 */

namespace Controllers;

use Views\Render;

class DefaultController
{
    private $view;

    public function __construct()
    {
        $this->view = new Render();
    }

    public function actionIndex()
    {
        return $this->view->display('default', array("default"=>''));
    }
}