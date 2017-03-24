<?php

/**
 * User: Joel Häberli
 * Date: 17.03.2017
 * Time: 08:43
 */
class User extends Model {
    
    private $idUser;
    private $username;
    private $password;
    private $prename;
    private $name;
    
    //TODO : create query-pattern
    const GET_USER_BY_NAME = "SELECT username, prename, name FROM user WHERE username = :username LIMIT 1;";
    const GET_USER_BY_ID   = "SELECT username, prename, name FROM user WHERE idUser = :id;";
    const ADD_USER         = "INSERT INTO user (username, password, prename, name) VALUES (:username, :password, :prename, :name);";
    
    const GET_PASSWORD_HASH = "SELECT password FROM user WHERE username = :username LIMIT 1;";
    
    const UPDATE_USERNAME = "UPDATE user SET username = :username WHERE idUser = :id;";
    const UPDATE_PASSWORD = "UPDATE user SET password = :password WHERE idUser = :id;";
    const UPDATE_PRENAME  = "UPDATE user SET prename = :prename WHERE idUser = :id;";
    const UPDATE_NAME     = "UPDATE user SET name = :name WHERE idUser = :id;";
    
    const DELETE_USER_BY_ID = "DELETE FROM user WHERE idUser = :id;";
    
    //FAILS
    const VERIFICATION_FAIL = "username or password is invalid";
    const QUERY_FAIL        = "We could not find this query";
    const UPDATE_FAIL       = "We could not execute the update, cause of invalid values";
    
    //You can initialize a user with the option to offer the PDO-object at initialization
    public function __construct($id = NULL, $username = NULL, $prename = NULL, $name = NULL, $password = NULL) {
        
        $this->idUser = $id;
        $this->username = $username;
        $this->prename = $prename;
        $this->name = $name;
        $this->password = $password;
    }
    
    //Verifys a user by his username and password
    public static function verifyUser($username, $password) {
        
        self::setQueryParameter(array('username' => $username));
        if ($user = self::modelSelect(self::SELECT_PASSWORD_HASH_STATEMENT)) {
            return password_verify($password, $user->getPassword());
        }
        else {
            $_GET['Fail'] = self::VERIFICATION_FAIL;
        }
    }
    
    public static function getUserByName(String $username) {
        
        self::setQueryParameter(array('username' => $username));
        
        return self::modelSelect(self::SELECT_USER_BY_NAME_STATEMENT);
    }
    
    public static function getUserById(Integer $id) {
        
        self::setQueryParameter(array('id' => $id));
        
        return self::modelSelect(self::SELECT_USER_BY_ID_STATEMENT);
    }
    
    //Adds user after checking if the same username already exists. Retutns true, if successfully added
    public static function addUser(String $username, String $password, String $prename, String $name) {
        
        if (self::userExist($username)) {
            $_GET['Fail'] = "This user is already exists";
            
            return FALSE;
        }
        else {
            self::setQueryParameter(array('username' => $username, 'password' => $password, 'prename' => $prename, 'name' => $name));
            self::modelInsert(self::ADD_USER_STATEMENT);
            
            return TRUE;
        }
    }
    
    public static function deleteUser($id) {
        
        self::setQueryParameter(array('id' => $id));
        self::modelDelete(self::DELETE_USER_BY_ID_STATEMENT);
    }
    
    public function updateUser($id, $username = NULL, $password = NULL, $prename = NULL, $name = NULL) {
        
        if (!($username == NULL) && !self::userExist($username)) {
            self::setQueryParameter(array('id' => $id, 'username' => $username));
            self::modelUpdate(self::UPDATE_USERNAME_STATEMENT);
        }
        else {
            $_GET['This username exists already'];
        }
        if (!($password == NULL)) {
            self::setQueryParameter(array('id' => $id, 'password' => $password));
            self::modelUpdate(self::UPDATE_PASSWORD_STATEMENT);
        }
        if (!($prename == NULL)) {
            self::setQueryParameter(array('id' => $id, 'prename' => $prename));
            self::modelUpdate(self::UPDATE_PRENAME_STATEMENT);
        }
        if (!($name == NULL)) {
            self::setQueryParameter(array('id' => $id, 'name' => $name));
            self::modelUpdate(self::UPDATE_NAME_STATEMENT);
        }
    }
    
    //SELECT
    const SELECT_USER_BY_NAME_STATEMENT  = 1;
    const SELECT_PASSWORD_HASH_STATEMENT = 2;
    const SELECT_USER_BY_ID_STATEMENT    = 3;
    
    private static function modelSelect(Integer $whichSelectStatement) {
        
        switch ($whichSelectStatement) {
            case self::SELECT_USER_BY_NAME_STATEMENT: //SELECT user by his name
                $result = self::$database->performQuery(self, self::GET_USER_BY_NAME);
    
                return new User(NULL, $result['username'], $result['prename'], $result['name']);
            case self::SELECT_PASSWORD_HASH_STATEMENT: //Get password hash by username for verification
                $result = self::$database->performQuery(self, self::GET_PASSWORD_HASH);
    
                return new User(NULL, NULL, NULL, NULL, $result['password']);
            case self::SELECT_USER_BY_ID_STATEMENT:
                $result = self::$database->performQuery(self, self::GET_USER_BY_ID);
    
                return new User(NULL, $result['username'], $result['prename'], $result['name']);
            default:
                $_GET['Fail'] = self::QUERY_FAIL;
                break;
        }
    }
    
    //INSERT
    const ADD_USER_STATEMENT = 1;
    
    private static function modelInsert(Integer $whichInsertStatement) {
        
        switch ($whichInsertStatement) {
            case self::ADD_USER_STATEMENT:
                self::$database->performQuery(self, self::ADDUSER);
                break;
            default:
                $_GET['Fail'] = self::QUERY_FAIL;
                break;
        }
    }
    
    //UPDATE
    const UPDATE_USERNAME_STATEMENT = 1;
    const UPDATE_PASSWORD_STATEMENT = 2;
    const UPDATE_PRENAME_STATEMENT  = 3;
    const UPDATE_NAME_STATEMENT     = 4;
    
    private static function modelUpdate(Integer $whichUpdateStatement) {
        
        switch ($whichUpdateStatement) {
            case self::UPDATE_USERNAME_STATEMENT:
                self::$database->performQuery(self, self::UPDATE_USERNAME);
                break;
            case self::UPDATE_PASSWORD_STATEMENT:
                self::$database->performQuery(self, self::UPDATE_PASSWORD);
                break;
            case self::UPDATE_PRENAME_STATEMENT:
                self::$database->performQuery(self, self::UPDATE_PRENAME);
                break;
            case self::UPDATE_NAME_STATEMENT:
                self::$database->performQuery(self, self::UPDATE_NAME);
                break;
            default:
                $_GET['Fail'] = self::QUERY_FAIL;
                break;
        }
    }
    
    //DELETE
    const DELETE_USER_BY_ID_STATEMENT = 1;
    
    private static function modelDelete(Integer $whichDeleteStatement) {
        
        switch ($whichDeleteStatement) {
            case self::DELETE_USER_BY_ID_STATEMENT:
                self::$database->performQuery(self, self::DELETE_USER_BY_ID);
                break;
            default:
                $_GET['Fail'] = self::QUERY_FAIL;
                break;
        }
    }
    
    //checks if a user exists or not
    private static function userExist($username) {
        
        $user = self::modelSelect(self::SELECT_USER_BY_NAME_STATEMENT);
        if (!($user->getUsername() == NULL)) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }
    
    //Hashs the password and returns it
    private function hashPassword($passwordClear) {
        
        return password_hash($passwordClear, PASSWORD_DEFAULT);
    }
    
    public function getIdUser() {
        
        return $this->idUser;
    }
    
    public function getUsername() {
        
        return $this->username;
    }
    
    public function getPrename() {
        
        return $this->prename;
    }
    
    public function getName() {
        
        return $this->name;
    }
    
    public function getPassword() {
        
        return $this->password;
    }
    
}