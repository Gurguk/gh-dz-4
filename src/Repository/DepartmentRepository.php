<?php

namespace Repository;

use Controllers\ConnectDB;

class DepartmentRepository extends Department implements DepartmentInterface
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
        $sql = 'CREATE TABLE IF NOT EXISTS department (
          id int(11) NOT NULL AUTO_INCREMENT,
          university_id int(11) NOT NULL,
          department_name VARCHAR (255) NOT NULL,
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
        $this->db->beginTransaction();
        $datafields = array('university_id', 'department_name');
        $names = array(
            '1' => array('Літакобудування', 'Авіаційних двигунів', 'Систем управління літаючими апаpатами',
                'Ракетно-коcмічної техніки', 'Радіотехнічних сиcтем літальних апаpатів', 'Економіки і менеджмeнту',
                'Гуманітаpний', ),
            '2' => array('Інcтитут економіки', 'Інcтитут менеджменту', 'Інcтитут упpавління бізнеcом',
                'Юридичний інститут', 'Інcтитут міжнаpодної тa піcлядипломної оcвіти', ),
            '3' => array('Менеджмент, маркетинг', 'Автоматизація, приладобудування', 'Інформаційні технології, кібербезпека',
                'Культура, мистецтво', 'Інженерія, машинобудування', 'Будівництво, архітектура', 'Філологія', 'Економіка', ),
            '4' => array('Педагогіка', 'Менеджмент, маркетинг', 'Готельно-ресторанна справа, туризм', 'Автоматизація, приладобудування',
                'Біологія, екологія', 'Журналістика, видавництво та поліграфія', 'Інформаційні технології, кібербезпека',
                'Історія, археологія', 'Культура, мистецтво', 'Математика, статистика', 'Психологія',
                'Соціологія, соціальна робота', 'Фізика, астрономія', 'Фізична культура', 'Філологія',
                'Філософія, релігія та культурологія', 'Хімія, біоінженерія', 'Економіка', 'Право', ),
            '5' => array('Економіка', 'Інше'),
            '6' => array('Цивільна безпека', 'Психологія', 'Інше'),
            '7' => array('Цивільна безпека', 'Право'),
        );
        $data = array();
        foreach ($names as $key => $value) {
            foreach ($value as $item) {
                $data[] = array('university_id' => $key, 'department_name' => $item);
            }
        }
        $insert_values = array();
        foreach ($data as $d) {
            $question_marks[] = '('.$this->placeholders('?', sizeof($d)).')';
            $insert_values = array_merge($insert_values, array_values($d));
        }
        $sql = 'INSERT INTO department ('.implode(', ', $datafields).') VALUES '.implode(',', $question_marks);
        $query = $this->db->prepare($sql);
        try {
            $query->execute($insert_values);
        } catch (\PDOException $error) {
            echo __LINE__;
            echo $error->getMessage();
        }
        $this->db->commit();

        return $query;
    }

    public function findOne($id)
    {
        $sql = 'SELECT department.id as id,department.department_name as name, university.id as university_id, university.university_name as university_name 
                FROM department LEFT JOIN university ON department.university_id=university.id  WHERE department.id=:id';
        $query = $this->db->prepare($sql);
        $query->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetchObject(Department::class);

        return $result;
    }

    public function findAll($limit = 100, $offset = 0)
    {
        if ($_POST['search'] != '') {
            $like = ' AND department_name LIKE "%:like%"';
        } else {
            $like = '';
        }
        $sql = 'SELECT * FROM department WHERE 1 '.$like.' ORDER BY id ASC LIMIT :limit OFFSET :offset';
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

    public function create(array $departmentData)
    {
        $sql = "INSERT INTO department (university_id, department_name) VALUES (':university_id',':department_name')";
        $query = $this->db->prepare($sql);
        $query->bindValue(':university_id', (int) $departmentData['university_id'], \PDO::PARAM_INT);
        $query->bindValue(':department_name', (string) $departmentData['name'], \PDO::PARAM_STR);
        try {
            $query->execute();
        } catch (\PDOException $error) {
            echo __LINE__;
            echo $error->getMessage();
        }

        return $this->db->lastInsertId();
    }

    public function update(array $departmentData)
    {
        $sql = "UPDATE department SET university_id='??', department_name='??' WHERE id='??'";
        $query = $this->db->prepare($sql);
        $query->bindValue(':university_id', (int) $departmentData['university_id'], \PDO::PARAM_INT);
        $query->bindValue(':name', (string) $departmentData['name'], \PDO::PARAM_STR);
        $query->bindValue(':id', (int) $departmentData['id'], \PDO::PARAM_INT);
        try {
            $query->execute();
        } catch (\PDOException $error) {
            echo __LINE__;
            echo $error->getMessage();
        }
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM department WHERE id=:id';
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
            return $this->create(array('university_id' => $this->university_id, 'name' => $this->name));
        } else {
            $this->update(array('university_id' => $this->university_id, 'name' => $this->name, 'id' => $this->id));
        }
    }

    private function placeholders($text, $count = 0, $separator = ',')
    {
        $result = array();
        if ($count > 0) {
            for ($x = 0; $x < $count; ++$x) {
                $result[] = $text;
            }
        }

        return implode($separator, $result);
    }
}
