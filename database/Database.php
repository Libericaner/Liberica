<?php

/**
 * Created by PhpStorm.
 * User: Joel Häberli
 * Date: 03.03.2017
 * Time: 10:09
 */
class Database {
    
    private $host;
    private $username;
    private $password;
    private $database;
    
    public function __construct(String $host, String $username, String $password, String $database) {
        
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }
    
    private function getConnection(String $host, String $username, String $password, String $database) {
        
        $c = new mysqli($host, $username, $password, $database);
        if ($c->connect_error == "") {
            return $c;
        } else {
            return $c->connect_error();
        }
    }
    
    public function select(Selectable $selectable) {
        
    }
    
    public function insert(Insertable $insertable) {
        
    }
    
    public function update(Updateable $updateable) {
        
    }
    
    public function delete(Deleteable $deleteable) {
        
    }
}