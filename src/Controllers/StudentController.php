<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 06.11.16
 * Time: 17:30.
 */

namespace Controllers;

use Repository\StudentRepository;
use Views\Render;

class StudentController
{
    private $student;

    private $view;

    public function __construct()
    {
        $this->student = new StudentRepository();
        $this->view = new Render();
    }

    public function actionIndex()
    {
        $data = $this->student->findAll();

        return $this->view->display('students', array('student' => $data));
    }

    public function actionDelete()
    {
        $this->student->delete($_GET['id']);
        header('Location: '.$_SERVER['HTTP_REFERER']);
        exit();
    }

    public function actionShow()
    {
        $data = $this->student->findOne($_GET['id']);

        return $this->view->display('student', array('student' => $data, 'do' => 'show'));
    }

    public function actionEdit()
    {
        $data = $this->student->findOne($_GET['id']);

        return $this->view->display('student', array('student' => $data, 'do' => $_GET['action']));
    }

    public function actionUpdate()
    {
        $data = $_POST['send'];
        $this->student->update($data);
        $url = str_replace('action=edit&do=edit', 'action=show', $_SERVER['HTTP_REFERER']);
        header('Location: '.$url);
        exit();
    }

    public function actionCreate()
    {
        return $this->view->display('student', array('student' => '', 'do' => 'create'));
    }

    public function actionAdd()
    {
        $data = $_POST['send'];
        $id = $this->student->create($data);
        $url = str_replace('action=create', 'action=show&id='.$id, $_SERVER['HTTP_REFERER']);
        header('Location: '.$url);
        exit();
    }
}
