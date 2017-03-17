<?php

/**
 * User: Joel Häberli
 * Date: 17.03.2017
 * Time: 13:10
 */
abstract class Model {
    
    //the database instance used by the model to communicate with the database
    protected $database;
    protected $queryParams;
    
    //Get the query parameter -> used from Database
    public function getQueryParameter() {
        
        return $this->queryParams;
    }
    
    //Set query parameters in a assoziative array to generate a proper query
    //Example: array('username'=>$username, 'password'=>$password, 'prename'=>$prename, 'name'=>$name)
    protected function setQueryParameter(Array $params) {
        
        $this->queryParams = $params;
    }
    
    //Set the database for connection
    public function setDatabase(Database $database) {
        
        $this->database = $database;
    }
}