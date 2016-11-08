<?php

namespace Models;

use Controllers\ConectDB;

class TeacherModel implements ModelsInterface
{
    private $db;

    public function __construct()
    {
        $this->db = new ConectDB();
        $this->init();
    }

    public function init()
    {
        $query = 'CREATE TABLE IF NOT EXISTS teacher (
          id int(11) NOT NULL AUTO_INCREMENT,
          department_id int(11) NOT NULL,
          first_name VARCHAR (55) NOT NULL,
          last_name VARCHAR (55) NOT NULL,          
           PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8;';

        $this->db->setQuery($query);
        $this->db->executeQuery();

        return $query;
    }

    public function addDemo()
    {
        $rows = array();
        for ($i = 0; $i < 50; ++$i) {
            $rows[] = $this->demoRow();
        }

        $query = 'INSERT INTO teacher (department_id, first_name, last_name) VALUES '.PHP_EOL.implode(', '.PHP_EOL, $rows);
        $this->db->setQuery($query);
        $this->db->executeQuery();

        return $query;
    }

    private function demoRow()
    {
        $result = array();
        $query = 'SELECT id FROM department ORDER BY RAND() LIMIT 1';
        $this->db->setQuery($query);
        $random = $this->db->getObject();
        array_push($result, $random->id);
        $first_name = array('Иванов', 'Петров', 'Сидоров', 'Кузнецов', 'Павлов', 'Котов', 'Лукин', 'Белкин');
        $first_name = $first_name[array_rand($first_name, 1)];
        array_push($result, $first_name);
        $last_name = array('Иван', 'Петр', 'Вадим', 'Борис', 'Андрей', 'Павел', 'Артем', 'Антон', 'Вадим');
        $last_name = $last_name[array_rand($last_name, 1)];
        array_push($result, $last_name);

        return "('".implode("', '", $result)."')";
    }

    public function findOne($id)
    {
        $query = 'SELECT * FROM teacher WHERE id='.$id.' ORDER BY ID';
        $this->db->setQuery($query);
        $result = $this->db->getObject();

        return $result;
    }

    public function findAll($limit = 100, $offset = 0)
    {
        if ($_POST['search'] != '') {
            $like = ' AND (first_name LIKE "%'.$_POST['search'].'%" OR last_name LIKE "%'.$_POST['search'].'%")';
        } else {
            $like = '';
        }
        $query = 'SELECT * FROM teacher WHERE 1 '.$like.' LIMIT '.$limit.' OFFSET '.$offset;
        $this->db->setQuery($query);
        $result = $this->db->getObjectList();

        return $result;
    }

    public function findList(array $teacherIds)
    {
        $list = implode(',', $teacherIds);
        $query = 'SELECT * FROM teacher WHERE id IN ('.$list.')';
        $this->db->setQuery($query);
        $result = $this->db->getObjectList();

        return $result;
    }

    public function create(array $teacherData)
    {
        $query = sprintf("INSERT INTO teacher (department_id, first_name, last_name) VALUES ('%s', '%s', '%s')", $teacherData['department_id'], $teacherData['first_name'], $teacherData['last_name']);
        $this->db->setQuery($query);
        $this->db->executeQuery($query);

        return $this->db->insert_id;
    }

    public function update(array $teacherData)
    {
        $query = sprintf("UPDATE teacher SET department_id='%s', first_name='%s', last_name='%s' WHERE id='%s'",  $teacherData['department_id'], $teacherData['first_name'], $teacherData['last_name'], $teacherData['id']);
        $this->db->setQuery($query);
        $this->db->executeQuery($query);
    }

    public function delete($id)
    {
        $query = sprintf('DELETE FROM teacher WHERE id='.$id);
        $this->db->setQuery($query);
        $this->db->executeQuery($query);
    }
}