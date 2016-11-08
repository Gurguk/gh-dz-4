<?php


namespace Controllers;

use Models\TeacherModel;
use Views\Render;

class TeacherController
{
    private $teacher;

    private $view;

    public function __construct()
    {
        $this->teacher = new TeacherModel();
        $this->view = new Render();

    }


    public function actionIndex()
    {
        $data = $this->teacher->findAll();

        return $this->view->display('teachers', array('teacher' => $data));
    }

    public function actionDelete()
    {
        $this->teacher->delete($_GET['id']);
        header('Location: '.$_SERVER['HTTP_REFERER']);
        exit();
    }

    public function actionShow()
    {
        $data = $this->teacher->findOne($_GET['id']);

        return $this->view->display('teacher', array('teacher' => $data, 'do' => 'show'));
    }

    public function actionEdit()
    {
        $data = $this->teacher->findOne($_GET['id']);

        return $this->view->display('teacher', array('teacher' => $data, 'do' => $_GET['action']));
    }

    public function actionUpdate()
    {
        $data = $_POST['send'];
        $this->teacher->update($data);
        $url = str_replace('action=edit&do=edit', 'action=show', $_SERVER['HTTP_REFERER']);
        header('Location: '.$url);
        exit();
    }

    public function actionCreate()
    {
        return $this->view->display('teacher', array('teacher' => '', 'do' => 'create'));
    }

    public function actionAdd()
    {
        $data = $_POST['send'];
        $id = $this->teacher->create($data);
        $url = str_replace('action=create', 'action=show&id='.$id, $_SERVER['HTTP_REFERER']);
        header('Location: '.$url);
        exit();
    }
}