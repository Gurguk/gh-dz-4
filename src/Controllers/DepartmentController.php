<?php

namespace Controllers;

use Repository\DepartmentRepository;
use Views\Render;

class DepartmentController
{
    private $department;

    private $view;

    public function __construct()
    {
        $this->department = new DepartmentRepository();
        $this->view = new Render();
    }

    public function actionIndex()
    {
        $data = $this->department->findAll();

        return $this->view->display('departments', array('departments' => $data));
    }

    public function actionDelete()
    {
        $this->department->delete($_GET['id']);
        header('Location: '.$_SERVER['HTTP_REFERER']);
        exit();
    }

    public function actionShow()
    {
        $data = $this->department->findOne($_GET['id']);

        return $this->view->display('department', array('department' => $data, 'do' => 'show'));
    }

    public function actionEdit()
    {
        $data = $this->department->findOne($_GET['id']);

        return $this->view->display('department', array('department' => $data, 'do' => $_GET['action']));
    }

    public function actionUpdate()
    {
        $data = $_POST['send'];
        $this->department->update($data);
        $url = str_replace('action=edit&do=edit', 'action=show', $_SERVER['HTTP_REFERER']);
        header('Location: '.$url);
        exit();
    }

    public function actionCreate()
    {
        return $this->view->display('department', array('department' => '', 'do' => 'create'));
    }

    public function actionAdd()
    {
        $data = $_POST['send'];
        $id = $this->department->create($data);
        $url = str_replace('action=create', 'action=show&id='.$id, $_SERVER['HTTP_REFERER']);
        header('Location: '.$url);
        exit();
    }
}
