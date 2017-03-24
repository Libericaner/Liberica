<?php

/**
 * User: Joel Häberli
 * Date: 17.03.2017
 * Time: 13:10
 */
abstract class Model {
    
    //the database instance used by the model to communicate with the database
    protected static $database;
    protected static $queryParams;
    
    //Get the query parameter -> used from Database
    public function getQueryParameter() {
    
        return self::$queryParams;
    }
    
    //Set query parameters in a assoziative array to generate a proper query
    //Example: array('username'=>$username, 'password'=>$password, 'prename'=>$prename, 'name'=>$name)
    protected static function setQueryParameter(Array $params) {
        
        self::$queryParams = $params;
    }
    
    //Set the database for connection
    public function setDatabase(Database $database) {
    
        self::$database = $database;
    }
}