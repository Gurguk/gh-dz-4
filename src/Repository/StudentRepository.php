<?php

namespace Repository;

use Controllers\ConnectDB;

class StudentRepository extends Student implements StudentInterface
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
        $sql = 'CREATE TABLE IF NOT EXISTS student (
          id int(11) NOT NULL AUTO_INCREMENT,
          department_id int(11) NOT NULL,
          first_name VARCHAR (55) NOT NULL,
          last_name VARCHAR (55) NOT NULL,
          email VARCHAR (155) NOT NULL,
          phone VARCHAR (25) NOT NULL,
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

        $sql = 'INSERT INTO student (department_id, first_name, last_name, email, phone) VALUES '.PHP_EOL.implode(', '.PHP_EOL, $rows);
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
        $email = strtolower($this->transliterate($first_name.'-'.$last_name.$random->id.'@gmail.com'));
        array_push($result, $email);
        $phone = implode('', array_rand(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9), 9));
        array_push($result, $phone);

        return "('".implode("', '", $result)."')";
    }

    private function transliterate($string)
    {
        $roman = array('Sch', 'sch', 'Yo', 'Zh', 'Kh', 'Ts', 'Ch', 'Sh', 'Yu', 'ya', 'yo', 'zh', 'kh', 'ts', 'ch', 'sh', 'yu', 'ya', 'A', 'B', 'V', 'G', 'D', 'E', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', '', 'Y', '', 'E', 'a', 'b', 'v', 'g', 'd', 'e', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', '', 'y', '', 'e');
        $cyrillic = array('Щ', 'щ', 'Ё', 'Ж', 'Х', 'Ц', 'Ч', 'Ш', 'Ю', 'я', 'ё', 'ж', 'х', 'ц', 'ч', 'ш', 'ю', 'я', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Ь', 'Ы', 'Ъ', 'Э', 'а', 'б', 'в', 'г', 'д', 'е', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'ь', 'ы', 'ъ', 'э');

        return str_replace($cyrillic, $roman, $string);
    }

    public function findOne($id)
    {
        $sql = 'SELECT * FROM student WHERE id=:id ORDER BY ID';
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
        $sql = 'SELECT * FROM student WHERE 1 '.$like.' LIMIT :limit OFFSET :offset';
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

    public function create(array $studentData)
    {
        $sql = "INSERT INTO student (department_id, first_name, last_name, email, phone) VALUES (':department_id', ':first_name', ':last_name', ':email', ':phone')";
        $query = $this->db->prepare($sql);
        $query->bindValue(':department_id', (int) $studentData['department_id'], \PDO::PARAM_INT);
        $query->bindValue(':first_name', (string) $studentData['first_name'], \PDO::PARAM_STR);
        $query->bindValue(':last_name', (string) $studentData['last_name'], \PDO::PARAM_STR);
        $query->bindValue(':email', (string) $studentData['email'], \PDO::PARAM_STR);
        $query->bindValue(':phone', (string) $studentData['phone'], \PDO::PARAM_STR);
        try {
            $query->execute();
        } catch (\PDOException $error) {
            echo __LINE__;
            echo $error->getMessage();
        }

        return $this->db->lastInsertId();
    }

    public function update(array $studentData)
    {
        $sql = "UPDATE student SET department_id=':department_id', first_name=':first_name', last_name=':last_name', email=':email', phone=':phone' WHERE id=':id'";
        $query = $this->db->prepare($sql);
        $query->bindValue(':department_id', (int) $studentData['department_id'], \PDO::PARAM_INT);
        $query->bindValue(':first_name', (string) $studentData['first_name'], \PDO::PARAM_STR);
        $query->bindValue(':last_name', (string) $studentData['last_name'], \PDO::PARAM_STR);
        $query->bindValue(':email', (string) $studentData['email'], \PDO::PARAM_STR);
        $query->bindValue(':phone', (string) $studentData['phone'], \PDO::PARAM_STR);
        $query->bindValue(':id', (int) $studentData['id'], \PDO::PARAM_INT);
        try {
            $query->execute();
        } catch (\PDOException $error) {
            echo __LINE__;
            echo $error->getMessage();
        }
    }

    public function delete($id)
    {
        $sql = sprintf('DELETE FROM student WHERE id=:id');
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
            return $this->create(array('department_id' => $this->department_id, 'first_name' => $this->first_name, 'last_name' => $this->last_name, 'email' => $this->email, 'phone' => $this->phone));
        } else {
            $this->update(array('department_id' => $this->department_id, 'first_name' => $this->first_name, 'last_name' => $this->last_name, 'email' => $this->email, 'phone' => $this->phone, 'id' => $this->id));
        }
    }
}
