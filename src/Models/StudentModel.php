<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 06.11.16
 * Time: 23:56
 */

namespace Models;


use Controllers\ConectDB;

class StudentModel
{
    private $db;

    public function __construct()
    {
        $this->db = new ConectDB();
        $this->init();
    }

    private function init()
    {
        $query = "CREATE TABLE IF NOT EXISTS student (
          id int(11) NOT NULL AUTO_INCREMENT,
          department_id int(11) NOT NULL,
          first_name VARCHAR (55) NOT NULL,
          last_name VARCHAR (55) NOT NULL,
          email VARCHAR (155) NOT NULL,
          phone VARCHAR (25) NOT NULL,
           PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

        $this->db->setQuery($query);
        return $this->db->executeQuery();
    }

    public function addDemo()
    {
        $rows = array();
        for ( $i=0; $i < 50; $i++) {
            $rows[] = $this->demoRow();
        }

        $query = "INSERT INTO student (department_id, first_name, last_name, email, phone) VALUES ".implode(',',$rows);
        $this->db->setQuery($query);
        return $this->db->executeQuery();
    }

    private function demoRow()
    {
        $result = array();
        $query = "SELECT id FROM department ORDER BY RAND() LIMIT 1";
        $this->db->setQuery($query);
        $random = $this->db->getObject();
        array_push($result,$random->id);
        $first_name = array('Иванов', 'Петров', 'Сидоров', 'Кузнецов', 'Павлов', 'Котов', 'Лукин', 'Белкин');
        $first_name = $first_name[array_rand($first_name, 1)];
        array_push($result,$first_name);
        $last_name = array('Иван', 'Петр', 'Вадим', 'Борис', 'Андрей', 'Павел', 'Артем', 'Антон', 'Вадим');
        $last_name = $last_name[array_rand($last_name, 1)];
        array_push($result,$last_name);
        $email = strtolower($this->transliterate($first_name . '-' . $last_name . $random->id . '@gmail.com'));
        array_push($result,$email);
        $phone = implode('',array_rand(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9), 9));
        array_push($result,$phone);
        return "('" . implode("', '",$result) . "')";
    }

    private function  transliterate($string)
    {
        $roman = array("Sch","sch",'Yo','Zh','Kh','Ts','Ch','Sh','Yu','ya','yo','zh','kh','ts','ch','sh','yu','ya','A','B','V','G','D','E','Z','I','Y','K','L','M','N','O','P','R','S','T','U','F','','Y','','E','a','b','v','g','d','e','z','i','y','k','l','m','n','o','p','r','s','t','u','f','','y','','e');
        $cyrillic = array("Щ","щ",'Ё','Ж','Х','Ц','Ч','Ш','Ю','я','ё','ж','х','ц','ч','ш','ю','я','А','Б','В','Г','Д','Е','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Ь','Ы','Ъ','Э','а','б','в','г','д','е','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','ь','ы','ъ','э');
        return str_replace($cyrillic, $roman, $string);
    }

    public function findOne($id)
    {
        $query = 'SELECT * FROM student WHERE id=' . $id . " ORDER BY ID";
        $this->db->setQuery($query);
        $result = $this->db->getObject();
        return $result;
    }

    public function findAll($limit = 100, $offset = 0)
    {
        if($_POST['search']!='')
            $like = ' AND (first_name LIKE "%' . $_POST['search'] . '%" OR last_name LIKE "%' . $_POST['search'] . '%")';
        else
            $like = '';
        $query = 'SELECT * FROM student WHERE 1 ' . $like . ' LIMIT ' . $limit . ' OFFSET ' . $offset;
        $this->db->setQuery($query);
        $result = $this->db->getObjectList();
        return $result;
    }

    public function findList(array $studentIds)
    {
        $list = implode(',', $studentIds);
        $query = 'SELECT * FROM student WHERE id IN (' . $list . ')';
        $this->db->setQuery($query);
        $result = $this->db->getObjectList();
        return $result;
    }

    public function create( array $studentData)
    {
        $query = sprintf("INSERT INTO student (department_id, first_name, last_name, email, phone) VALUES ('%s', '%s', '%s', '%s', '%s')", $studentData['department_id'], $studentData['first_name'], $studentData['last_name'], $studentData['email'], $studentData['phone']);
        $this->db->setQuery($query);
        $this->db->executeQuery($query);
        return $this->db->insert_id;
    }

    public function update( array $studentData)
    {
        $query = sprintf("UPDATE student SET department_id='%s', first_name='%s', last_name='%s', email='%s', phone='%s' WHERE id='%s'",  $studentData['department_id'], $studentData['first_name'], $studentData['last_name'], $studentData['email'], $studentData['phone'], $studentData['id']);
        $this->db->setQuery($query);
        $this->db->executeQuery($query);
    }

    public function delete( $id )
    {
        $query = sprintf("DELETE FROM student WHERE id=". $id);
        $this->db->setQuery($query);
        $this->db->executeQuery($query);
    }
}