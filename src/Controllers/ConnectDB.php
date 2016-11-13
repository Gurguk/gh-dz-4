<?php

namespace Controllers;

class ConnectDB extends Configuration
{
    private $_connection;

    private static $_instance;

    /*
    Get an instance of the Database
    @return Instance
    */
    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    private function __construct()
    {
        try {
            $configuration = new Configuration();
            $this->_connection = new \PDO("mysql:host=$configuration->host;dbname=$configuration->database", $configuration->username, $configuration->password, array(
                \PDO::ATTR_PERSISTENT => true,
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            ));
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

    private function __clone()
    {
        return false;
    }

    public function __wakeup()
    {
        return false;
    }

    public function getConnection()
    {
        return $this->_connection;
    }
}
