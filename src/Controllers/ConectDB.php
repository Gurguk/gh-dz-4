<?php

namespace Controllers;


class ConectDB
{
    private $mysqli;

    private $query;

    public $insert_id;

    public function __construct()
    {
        $configuration = new Configuration();

        $this->mysqli = new \mysqli( $configuration->host, $configuration->user, $configuration->password, $configuration->database);
        if (!$this->mysqli) {
            return false;
        }
        $this->mysqli->set_charset("utf8");

    }

    public function getDB()
    {
        return $this->mysqli;
    }

    /*
     * For this function can be added some prepared actions
     * */
    public function setQuery($query){
        return $this->query = $query;
    }

    public function executeQuery(){
        $return = $this->mysqli->query($this->query);
        $this->insert_id = $this->mysqli->insert_id;
        return $return;
    }

    public function getArray(){
        $result = $this->mysqli->query($this->query);
        $return = $result->fetch_row();
        return $return;
    }

    public function getObject(){
        $result = $this->mysqli->query($this->query);
        $return =  $result->fetch_object();
        return $return;
    }

    public function getArrayList(){
        $result = $this->mysqli->query($this->query);
        $return = array();
        while($row = $result->fetch_assoc()){
            $return[] = $row;
        }
        return $return;
    }

    public function getObjectList(){
        $result = $this->mysqli->query($this->query);
        $return = array();
        while($row = $result->fetch_object()){
            $return[] = $row;
        }
        return $return;
    }
}