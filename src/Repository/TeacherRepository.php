<?php

namespace Repository;

use Controllers\ConnectDB;

class TeacherRepository extends Teacher implements TeacherInterface
{
    private $db;

    public function __construct($id = 0)
    {
        $dbp = ConnectDB::getInstance();
        $this->db = $dbp->getConnection();
        $this->init();
        if ($id != 0) {
            $this->findOne($id);
        }
    }

    public function init()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS teacher (
          id int(11) NOT NULL AUTO_INCREMENT,
          department_id int(11) NOT NULL,
          first_name VARCHAR (55) NOT NULL,
          last_name VARCHAR (55) NOT NULL,          
           PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8;';

        try {
            $this->db->query($sql);
        } catch (\PDOException $error) {
            echo __LINE__;
            echo $error->getMessage();
        }

        return $sql;
    }

    public function addDemo()
    {
        $rows = array();
        for ($i = 0; $i < 50; ++$i) {
            $rows[] = $this->demoRow();
        }

        $sql = 'INSERT INTO teacher (department_id, first_name, last_name) VALUES '.PHP_EOL.implode(', '.PHP_EOL, $rows);
        $query = $this->db->prepare($sql);
        try {
            $query->execute($query);
        } catch (\PDOException $error) {
            echo __LINE__;
            echo $error->getMessage();
        }

        return $sql;
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
        $sql = 'SELECT * FROM teacher WHERE id='.$id.' ORDER BY ID';
        $query = $this->db->prepare($sql);
        $query->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetchObject(Department::class);

        return $result;
    }

    public function findAll($limit = 100, $offset = 0)
    {
        if ($_POST['search'] != '') {
            $like = ' AND (first_name LIKE "%:like1%" OR last_name LIKE "%:like2%")';
        } else {
            $like = '';
        }
        $sql = 'SELECT * FROM teacher WHERE 1 '.$like.' LIMIT :limit OFFSET :offset';
        $query = $this->db->prepare($sql);
        if (!empty($_POST['search'])) {
            $query->bindValue(':like1', (string) $_POST['search'], \PDO::PARAM_STR);
            $query->bindValue(':like2', (string) $_POST['search'], \PDO::PARAM_STR);
        }
        $query->bindValue(':limit', (int) $limit, \PDO::PARAM_INT);
        $query->bindValue(':offset', (int) $offset, \PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_CLASS, Department::class);

        return $result;
    }

    public function create(array $teacherData)
    {
        $sql = "INSERT INTO teacher (department_id, first_name, last_name) VALUES (':department_id', ':first_name', ':last_name')";
        $query = $this->db->prepare($sql);
        $query->bindValue(':department_id', (int) $teacherData['department_id'], \PDO::PARAM_INT);
        $query->bindValue(':first_name', (string) $teacherData['first_name'], \PDO::PARAM_STR);
        $query->bindValue(':last_name', (string) $teacherData['last_name'], \PDO::PARAM_STR);
        try {
            $query->execute();
        } catch (\PDOException $error) {
            echo __LINE__;
            echo $error->getMessage();
        }

        return $this->db->lastInsertId();
    }

    public function update(array $teacherData)
    {
        $sql = "UPDATE teacher SET department_id=':department_id', first_name=':first_name', last_name=':last_name' WHERE id=':id'";
        $query = $this->db->prepare($sql);
        $query->bindValue(':department_id', (int) $teacherData['department_id'], \PDO::PARAM_INT);
        $query->bindValue(':first_name', (string) $teacherData['first_name'], \PDO::PARAM_STR);
        $query->bindValue(':last_name', (string) $teacherData['last_name'], \PDO::PARAM_STR);
        try {
            $query->execute();
        } catch (\PDOException $error) {
            echo __LINE__;
            echo $error->getMessage();
        }
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM teacher WHERE id=:id';
        $query = $this->db->prepare($sql);
        $query->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        try {
            $query->execute();
        } catch (\PDOException $error) {
            echo __LINE__;
            echo $error->getMessage();
        }
    }
    public function set()
    {
        if (empty($this->id)) {
            return $this->create(array('department_id' => $this->department_id, 'first_name' => $this->first_name, 'last_name' => $this->last_name));
        } else {
            $this->update(array('department_id' => $this->department_id, 'first_name' => $this->first_name, 'last_name' => $this->last_name, 'id' => $this->id));
        }
    }
}
