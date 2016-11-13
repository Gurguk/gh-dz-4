<?php

namespace Repository;

use Controllers\ConnectDB;

class UniversityRepository extends University implements UniversityInterface
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
        $sql = 'CREATE TABLE IF NOT EXISTS university (
          id int(11) NOT NULL AUTO_INCREMENT,
          university_name VARCHAR (255) NOT NULL,
          university_city VARCHAR (55) NOT NULL,
          university_site VARCHAR (255) NOT NULL,
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
        $sql = "INSERT INTO university (university_name, university_city, university_site) VALUES
                ('Черкаська філія Харківського аерокосмічного унірерситет ім. Н. Є. Жуковського', 'Черкаси', 'khai.edu'),
                ('Східноєвропейський університет економіки і менеджменту (СУЕМ)', 'Черкаси', 'suem.edu.ua'),
                ('Черкаський державний технологічний університет (ЧДТУ)', 'Черкаси', 'chdtu.edu.ua'),
                ('Черкаський національний університет імені Богдана Хмельницького (ЧНУ)', 'Черкаси', 'cdu.edu.ua'),
                ('Черкаський інститут банківської справи Університету банківської справи Національного банку України', 'Черкаси', 'cibs.ck.ua'),
                ('Черкаський інститут пожежної безпеки імені Героїв Чорнобиля Національного університету цивільного захисту України', 'Черкаси', 'www.fire.ck.ua'),
                ('Черкаський факультет Національного університету «Одеська юридична академія»', 'Черкаси', 'www.onua.ck.ua')
        ";
        try {
            $this->db->query($sql);
        } catch (\PDOException $error) {
            echo __LINE__;
            echo $error->getMessage();
        }

        return $sql;
    }

    public function findOne($id)
    {
        $sql = 'SELECT * FROM university WHERE id=:id ORDER BY ID';
        $query = $this->db->prepare($sql);
        $query->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetchObject(Department::class);

        return $result;
    }

    public function findAll($limit = 100, $offset = 0)
    {
        if ($_POST['search'] != '') {
            $like = ' AND university_name LIKE "%:like%"';
        } else {
            $like = '';
        }
        $sql = 'SELECT * FROM university WHERE 1 '.$like.' LIMIT :limit OFFSET :offset';
        $query = $this->db->prepare($sql);
        if (!empty($_POST['search'])) {
            $query->bindValue(':like', (string) $_POST['search'], \PDO::PARAM_STR);
        }
        $query->bindValue(':limit', (int) $limit, \PDO::PARAM_INT);
        $query->bindValue(':offset', (int) $offset, \PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_CLASS, Department::class);

        return $result;
    }

    public function create(array $universityData)
    {
        $sql = "INSERT INTO university (university_name, university_city, university_site) VALUES (':university_name',':university_city',':university_site')";
        $query = $this->db->prepare($sql);
        $query->bindValue(':university_name', (string) $universityData['name'], \PDO::PARAM_STR);
        $query->bindValue(':university_city', (string) $universityData['city'], \PDO::PARAM_STR);
        $query->bindValue(':university_site', (string) $universityData['site'], \PDO::PARAM_STR);
        try {
            $query->execute();
        } catch (\PDOException $error) {
            echo __LINE__;
            echo $error->getMessage();
        }

        return $this->db->lastInsertId();
    }

    public function update(array $universityData)
    {
        $sql = "UPDATE university SET university_name=':university_name', university_city=':university_city', university_site=':university_site' WHERE id=':id'";
        $query = $this->db->prepare($sql);
        $query->bindValue(':university_name', (string) $universityData['name'], \PDO::PARAM_STR);
        $query->bindValue(':university_city', (string) $universityData['city'], \PDO::PARAM_STR);
        $query->bindValue(':university_site', (string) $universityData['site'], \PDO::PARAM_STR);
        $query->bindValue(':id', (int) $universityData['id'], \PDO::PARAM_INT);
        try {
            $query->execute();
        } catch (\PDOException $error) {
            echo __LINE__;
            echo $error->getMessage();
        }
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM university WHERE id=:id';
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
            return $this->create(array('name' => $this->university_name, 'city' => $this->university_city, 'site' => $this->university_site));
        } else {
            $this->update(array('name' => $this->university_name, 'city' => $this->university_city, 'site' => $this->university_site, 'id' => $this->id));
        }
    }
}
