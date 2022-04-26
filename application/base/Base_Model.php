<?php

namespace Application\Base;

use Application\Helpers\LogManager;
use PDO;
use PDOException;

class Base_Model {

    protected PDO $db;
    protected Array $properties = [];

    public function __construct() {

        LogManager::add("Model", get_called_class() . " model called!");
        
        try {
            
            $this->db = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHAR, DB_USER, DB_PASS);
            LogManager::add("Model", get_called_class() . " model has established new db connection!");

        } catch(PDOException $e) {

            LogManager::add("PDO", $e->getMessage());

        }
    }

    public function __destruct() {
        
        LogManager::add("Model", get_called_class() . " model destructed!");
    }

    public function __set(string $key, mixed $value) {

        $this->properties[$key] = $value;
    }

    public function __get(string $key) : mixed {

        return (isset($this->properties[$key])) ? $this->properties[$key] : null;
    }

    public function toJSON() {

        return json_encode($this->properties, JSON_UNESCAPED_UNICODE|JSON_FORCE_OBJECT);
    }

    protected function getTableName() : String {

        $lpart = explode("\\", get_called_class());
        $class = strtolower(end($lpart));

        return  substr($class, -1) == 'y' ? substr($class, 0, -1) . "ies" : $class . "s";
    }

    public function find(Array $filters = [], int $limit = 0) {

        $sql = "SELECT * FROM " . $this->getTableName();

        if(count($filters) > 0) {

            $sql .= " WHERE ";
            foreach($filters as $key => $val) {

                $sql .= $key . "='" . $val . "', ";
            }
            $sql = substr($sql, 0, -2);
        }

        if($limit > 0) $sql .= " LIMIT " . $limit;

        $statement = $this->db->query($sql);
        $statement->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $result = $statement->fetchAll();

        LogManager::add("Model", get_called_class() . " model found " . count($result) . " rows!");

        return $result;
    }

    public function save() {

        $sql = (!isset($this->properties["id"])) ? "INSERT INTO " . $this->getTableName() : "UPDATE " . $this->getTableName() . " SET ";

        if(isset($this->properties["id"])) {

            foreach($this->properties as $key => $val) {

                if($key != "id") $sql .= $key . "='" . $val . "', ";
            }

            $sql  = substr($sql, 0, -2);
            $sql .= " WHERE id=" . $this->properties["id"];

        } else {

            foreach($this->properties as $key => $val) {

                $keyArr[] = $key;
                $valArr[] = "'" . $val . "'";
            }

            $sql .= " (" . implode(", ", $keyArr) . ") VALUES (" . implode(", " . $valArr) . ")";

        }
        
        $statement = $this->db->query($sql);

        LogManager::add("Model", get_called_class() . " model affected " . $statement->rowCount() . " rows!");
    }

    public function delete() {

        if(isset($this->properties["id"])) {

            $statement = $this->db->query("DELETE FROM " . $this->getTableName() . " WHERE id=" . $this->properties["id"]);

            if($statement->rowCount() > 0)
                LogManager::add("Model", get_called_class() . " model deleted entry #" . $this->properties["id"]);
            else
                LogManager::add("Model", get_called_class() . " model can't execute DELETE query for entry #" . $this->properties["id"]);

        } else LogManager::add("Model", get_called_class() . " model can't execute DELETE query!");
    }
}