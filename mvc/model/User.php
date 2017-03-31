<?php

/**
 * User: Joel Häberli
 * Date: 17.03.2017
 * Time: 08:43
 */

require_once "mvc/model/Model.php";

class User extends Model {
    
    private $id;
    private $email;
    private $password;
    private $prename;
    private $name;
    
    //TODO : create query-pattern
    const GET_USER_BY_NAME = "SELECT email FROM user WHERE email = :email LIMIT 1;";
    const GET_USER_BY_ID   = "SELECT email FROM user WHERE id = :id;";
    const ADD_USER         = "INSERT INTO user (email, password) VALUES (:email, :password);";
    
    const GET_PASSWORD_HASH = "SELECT password FROM user WHERE email = :email LIMIT 1;";
    
    const UPDATE_USERNAME = "UPDATE user SET email = :email WHERE id = :id;";
    const UPDATE_PASSWORD = "UPDATE user SET password = :password WHERE id = :id;";
    
    const DELETE_USER_BY_ID = "DELETE FROM user WHERE id = :id;";
    
    //FAILS
    const VERIFICATION_FAIL = "username or password is invalid";
    const QUERY_FAIL        = "We could not find this query";
    const UPDATE_FAIL       = "We could not execute the update, cause of invalid values";
    
    private static $fails;
    
    //You can initialize a user with the option to offer the PDO-object at initialization
    public function __construct($id = NULL, $email = NULL, $password = NULL) {
        
        $this->idUser = $id;
        $this->email = $email;
        $this->password = $password;
    }
    
    //Verifys a user by his username and password
    public static function verifyUser($email, $password) {
        
        self::setQueryParameter(array('email' => $email));
        if ($user = self::modelSelect(self::SELECT_PASSWORD_HASH_STATEMENT)) {
            return password_verify($password, $user->getPassword());
        }
        else {
            self::$fails = self::VERIFICATION_FAIL;
        }
    }
    
    public static function getUserByEmail(String $email) {
        
        self::setQueryParameter(array('email' => $email));
        
        return self::modelSelect(self::SELECT_USER_BY_NAME_STATEMENT);
    }
    
    public static function getUserById(Integer $id) {
        
        self::setQueryParameter(array('id' => $id));
        
        return self::modelSelect(self::SELECT_USER_BY_ID_STATEMENT);
    }
    
    //Adds user after checking if the same username already exists. Retutns true, if successfully added
    public static function addUser(String $email, String $password) {
        
        if (self::userExist($email)) {
            $_GET['Fail'] = "This user is already exists";
            
            return FALSE;
        }
        else {
            self::setQueryParameter(array('email' => $email, 'password' => self::hashPassword($password)));
            self::modelInsert(self::ADD_USER_STATEMENT);
            
            return TRUE;
        }
    }
    
    public static function deleteUser($id) {
        
        self::setQueryParameter(array('id' => $id));
        self::modelDelete(self::DELETE_USER_BY_ID_STATEMENT);
    }
    
    public function updateUser($id, $email = NULL, $password = NULL) {
        
        if (!($email == NULL) && !self::userExist($email)) {
            self::setQueryParameter(array('id' => $id, 'username' => $email));
            self::modelUpdate(self::UPDATE_USERNAME_STATEMENT);
        }
        else {
            $_GET['This username exists already'];
        }
        if (!($password == NULL)) {
            self::setQueryParameter(array('id' => $id, 'password' => $password));
            self::modelUpdate(self::UPDATE_PASSWORD_STATEMENT);
        }
    }
    
    public static function getFail() {
        
        return self::fails;
    }
    
    //SELECT
    const SELECT_USER_BY_NAME_STATEMENT  = 1;
    const SELECT_PASSWORD_HASH_STATEMENT = 2;
    const SELECT_USER_BY_ID_STATEMENT    = 3;
    
    private static function modelSelect($whichSelectStatement) {
        
        $u = new User();
        switch ($whichSelectStatement) {
            case self::SELECT_USER_BY_NAME_STATEMENT: //SELECT user by his name
                $result = self::$database->performQuery($u, self::GET_USER_BY_NAME);
                
                if (count($result) == 0)
                {
                    return new User();
                }
                return new User(NULL, $result[0]['email']);
            case self::SELECT_PASSWORD_HASH_STATEMENT: //Get password hash by username for verification
                $result = self::$database->performQuery($u, self::GET_PASSWORD_HASH);
    
                return new User(NULL, NULL, $result[0]['password']);
            case self::SELECT_USER_BY_ID_STATEMENT:
                $result = self::$database->performQuery($u, self::GET_USER_BY_ID);
    
                return new User(NULL, $result[0]['email']);
            default:
                self::$fails = self::QUERY_FAIL;
                break;
        }
    }
    
    //INSERT
    const ADD_USER_STATEMENT = 1;
    
    private static function modelInsert($whichInsertStatement) {
        
        $u = new User();
        switch ($whichInsertStatement) {
            case self::ADD_USER_STATEMENT:
                self::$database->performQuery($u, self::ADD_USER);
                break;
            default:
                self::$fails = self::QUERY_FAIL;
                break;
        }
    }
    
    //UPDATE
    const UPDATE_USERNAME_STATEMENT = 1;
    const UPDATE_PASSWORD_STATEMENT = 2;
    const UPDATE_PRENAME_STATEMENT  = 3;
    const UPDATE_NAME_STATEMENT     = 4;
    
    private static function modelUpdate($whichUpdateStatement) {
        
        $u = new User();
        switch ($whichUpdateStatement) {
            case self::UPDATE_USERNAME_STATEMENT:
                self::$database->performQuery($u, self::UPDATE_USERNAME);
                break;
            case self::UPDATE_PASSWORD_STATEMENT:
                self::$database->performQuery($u, self::UPDATE_PASSWORD);
                break;
            case self::UPDATE_PRENAME_STATEMENT:
                self::$database->performQuery($u, self::UPDATE_PRENAME);
                break;
            case self::UPDATE_NAME_STATEMENT:
                self::$database->performQuery($u, self::UPDATE_NAME);
                break;
            default:
                self::$fails = self::QUERY_FAIL;
                break;
        }
    }
    
    //DELETE
    const DELETE_USER_BY_ID_STATEMENT = 1;
    
    private static function modelDelete($whichDeleteStatement) {
        
        $u = new User();
        switch ($whichDeleteStatement) {
            case self::DELETE_USER_BY_ID_STATEMENT:
                self::$database->performQuery($u, self::DELETE_USER_BY_ID);
                break;
            default:
                self::$fails = self::QUERY_FAIL;
                break;
        }
    }
    
    //checks if a user exists or not
    private static function userExist($email) {
        
        self::setQueryParameter(array('email' => $email));
        $user = self::modelSelect(self::SELECT_USER_BY_NAME_STATEMENT);
        if (!($user->getEmail() == NULL)) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
    
    //Hashs the password and returns it
    private static function hashPassword($passwordClear) {
        
        return password_hash($passwordClear, PASSWORD_DEFAULT);
    }
    
    public function getIdUser() {
        
        return $this->id;
    }
    
    public function getEmail() {
        
        return $this->email;
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