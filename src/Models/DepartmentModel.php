<?php

namespace Models;

use Controllers\ConectDB;

class DepartmentModel implements ModelsInterface
{
    private $db;

    public function __construct()
    {
        $this->db = new ConectDB();
        $this->init();
    }
    public function init()
    {
        $query = 'CREATE TABLE IF NOT EXISTS department (
          id int(11) NOT NULL AUTO_INCREMENT,
          university_id int(11) NOT NULL,
          department_name VARCHAR (255) NOT NULL,
           PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8;';

        $this->db->setQuery($query);
        $this->db->executeQuery();

        return $query;
    }

    public function addDemo()
    {
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
        $query = 'INSERT INTO department (university_id, department_name) VALUES '.PHP_EOL;
        $rows = array();
        foreach ($names as $key => $value) {
            foreach ($value as $item) {
                $rows[] = '('.$key.", '".$item."')";
            }
        }
        $query .= implode(', '.PHP_EOL, $rows);
        $this->db->setQuery($query);
        $this->db->executeQuery();

        return $query;
    }

    public function findOne($id)
    {
        $query = 'SELECT department.id as id,department.department_name as name, university.id as university_id, university.university_name as university_name FROM department LEFT JOIN university ON department.university_id=university.id  WHERE department.id='.$id;
        $this->db->setQuery($query);
        $result = $this->db->getObject();

        return $result;
    }

    public function findAll($limit = 100, $offset = 0)
    {
        if ($_POST['search'] != '') {
            $like = ' AND department_name LIKE "%'.$_POST['search'].'%"';
        } else {
            $like = '';
        }
        $query = 'SELECT * FROM department WHERE 1 '.$like.' ORDER BY id ASC LIMIT '.$limit.' OFFSET '.$offset;
        $this->db->setQuery($query);
        $result = $this->db->getObjectList();

        return $result;
    }

    public function findList(array $departmentIds)
    {
        $list = implode(',', $departmentIds);
        $query = 'SELECT * FROM department WHERE id IN ('.$list.')';
        $this->db->setQuery($query);
        $result = $this->db->getObjectList();

        return $result;
    }

    public function create(array $departmentData)
    {
        $query = sprintf("INSERT INTO department (university_id, department_name) VALUES ('%s','%s')", $departmentData['university_id'], $departmentData['name']);
        $this->db->setQuery($query);
        $this->db->executeQuery($query);

        return $this->db->insert_id;
    }

    public function update(array $departmentData)
    {
        $query = sprintf("UPDATE department SET university_id='%s', department_name='%s' WHERE id='%s'", $departmentData['university_id'], $departmentData['name'], $departmentData['id']);
        $this->db->setQuery($query);
        $this->db->executeQuery($query);
    }

    public function delete($id)
    {
        $query = sprintf('DELETE FROM department WHERE id='.$id);
        $this->db->setQuery($query);
        $this->db->executeQuery($query);
    }
}
