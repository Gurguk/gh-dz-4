<?php

namespace Controllers;

use Models\UniversityModel;
use Views\Render;

class UniversityController
{
    private $university;

    private $view;

    public function __construct()
    {
        $this->university = new UniversityModel();
        $this->view = new Render();
    }

    public function actionIndex()
    {
        $data = $this->university->findAll();

        return $this->view->display('universities', array('universities' => $data));
    }

    public function actionDelete()
    {
        $this->university->delete($_GET['id']);
        header('Location: '.$_SERVER['HTTP_REFERER']);
        exit();
    }

    public function actionShow()
    {
        $data = $this->university->findOne($_GET['id']);

        return $this->view->display('university', array('university' => $data, 'do' => 'show'));
    }

    public function actionEdit()
    {
        $data = $this->university->findOne($_GET['id']);

        return $this->view->display('university', array('university' => $data, 'do' => $_GET['action']));
    }

    public function actionUpdate()
    {
        $data = $_POST['send'];
        $this->university->update($data);
        $url = str_replace('action=edit&do=edit', 'action=show', $_SERVER['HTTP_REFERER']);
        header('Location: '.$url);
        exit();
    }

    public function actionCreate()
    {
        return $this->view->display('university', array('university' => '', 'do' => 'create'));
    }

    public function actionAdd()
    {
        $data = $_POST['send'];
        $id = $this->university->create($data);
        $url = str_replace('action=create', 'action=show&id='.$id, $_SERVER['HTTP_REFERER']);
        header('Location: '.$url);
        exit();
    }
}
