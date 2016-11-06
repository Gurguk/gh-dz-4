<?php

namespace Models;

use Controllers\ConectDB;

class UniversityModel implements ModelsInterface
{
    private $db;

    public function __construct()
    {
        $this->db = new ConectDB();
        $this->init();
        $this->addDemo();

    }
    private function init()
    {
        $query = "CREATE TABLE IF NOT EXISTS university (
          id int(11) NOT NULL AUTO_INCREMENT,
          university_name VARCHAR (255) NOT NULL,
          university_city VARCHAR (55) NOT NULL,
          university_site VARCHAR (255) NOT NULL,
           PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

        $this->db->setQuery($query);
        return $this->db->executeQuery();
    }

    public function addDemo()
    {
       $query = "INSERT INTO university (university_name, university_city, university_site) VALUES
                ('Черкаська філія Харківського аерокосмічного унірерситет ім. Н. Є. Жуковського', 'Черкаси', 'khai.edu'),
                ('Східноєвропейський університет економіки і менеджменту (СУЕМ)', 'Черкаси', 'suem.edu.ua'),
                ('Черкаський державний технологічний університет (ЧДТУ)', 'Черкаси', 'chdtu.edu.ua'),
                ('Черкаський національний університет імені Богдана Хмельницького (ЧНУ)', 'Черкаси', 'cdu.edu.ua'),
                ('Черкаський інститут банківської справи Університету банківської справи Національного банку України', 'Черкаси', 'cibs.ck.ua'),
                ('Черкаський інститут пожежної безпеки імені Героїв Чорнобиля Національного університету цивільного захисту України', 'Черкаси', 'www.fire.ck.ua'),
                ('Черкаський факультет Національного університету «Одеська юридична академія»', 'Черкаси', 'www.onua.ck.ua')
        ";
        $this->db->setQuery($query);
        return $this->db->executeQuery();
    }

    public function findOne($id)
    {
        $query = 'SELECT * FROM university WHERE id=' . $id . " ORDER BY ID";
        $this->db->setQuery($query);
        $result = $this->db->getObject();
        return $result;
    }

    public function findAll($limit = 100, $offset = 0)
    {
        if($_POST['search']!='')
            $like = ' AND university_name LIKE "%' . $_POST['search'] . '%"';
        else
            $like = '';
        $query = 'SELECT * FROM university WHERE 1 ' . $like . ' LIMIT ' . $limit . ' OFFSET ' . $offset;
        $this->db->setQuery($query);
        $result = $this->db->getObjectList();
        return $result;
    }

    public function findList(array $universityIds)
    {
        $list = implode(',', $universityIds);
        $query = 'SELECT * FROM university WHERE id IN (' . $list . ')';
        $this->db->setQuery($query);
        $result = $this->db->getObjectList();
        return $result;
    }

    public function create( array $universityData)
    {
        $query = sprintf("INSERT INTO university (university_name, university_city, university_site) VALUES ('%s','%s','%s')",$universityData['name'],$universityData['city'],$universityData['site']);
        $this->db->setQuery($query);
        $this->db->executeQuery($query);
        return $this->db->insert_id;
    }

    public function update( array $universityData)
    {
        $query = sprintf("UPDATE university SET university_name='%s', university_city='%s', university_site='%s' WHERE id='%s'",$universityData['name'],$universityData['city'],$universityData['site'],$universityData['id']);
        $this->db->setQuery($query);
        $this->db->executeQuery($query);
    }

    public function delete( $id )
    {
        $query = sprintf("DELETE FROM university WHERE id=". $id);
        $this->db->setQuery($query);
        $this->db->executeQuery($query);
    }
}