<?php

/**
 * User: Joel Häberli
 * Date: 17.03.2017
 * Time: 13:10
 */
abstract class Model {
    
    //the Database instance used by the Model to communicate with the Database
    protected static $database;
    protected static $queryParams;
    
    //Get the query parameter -> used from Database
    public static function getQueryParameter() {
    
        return self::$queryParams;
    }
    
    //Set query parameters in a assoziative array to generate a proper query
    //Example: array('username'=>$username, 'password'=>$password, 'prename'=>$prename, 'name'=>$name)
    protected static function setQueryParameter(Array $params) {
        
        self::$queryParams = $params;
    }
    
    protected static function query($className, $queryParameter, $preparedStatement) {
        
        self::setQueryParameter($queryParameter);
        return $className::getObjects(self::$database->performQuery($preparedStatement));
    }
    
    //Sets the object-properties in the specific models and returns an array of objects of the specific models
    //Simple description: 'converts' results into the right object-type
    abstract public static function getObjects($result);
    
    //Set the database for connection
    public static function setDatabase(Database $database) {
    
        self::$database = $database;
    }
}