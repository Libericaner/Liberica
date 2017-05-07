<?php

/**
 * User: Joel Häberli
 * Date: 03.03.2017
 * Time: 11:31
 */
class Database {
    
    const DB_FAIL = "Error while loading Database connection. Please check the params";
    
    private $host;
    private $username;
    private $password;
    private $database;
    
    private $connection;
    
    public function __construct(String $host, String $username, String $password, String $database) {
        
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    
        $this->getDatabaseConnection();
    }
    
    public function getDatabaseConnection() {
    
        try {
            $conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database, $this->username, $this->password);
            $this->connection = $conn;
            return $conn;
        } catch (PDOException $e) {
            echo 'Verbindung fehlgeschlagen: ' . $e->getMessage();
            exit;
        }
    }
    
    public function performQuery($model, $queryPattern) {
        
        
        $stmt = $this->connection->prepare($queryPattern);
        
        $stmt->execute($model::getQueryParameter());
        
        $result = array();
        
        while ($record = $stmt->fetch()) {
            $result[] = $record;
        }
        
        return $result;
    }
}