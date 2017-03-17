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
    public function __construct(PDO $database = NULL) {
        
        if (!($database == NULL)) {
            $this->setDatabase($database);
        }
    }
    
    //Verifys a user by his username and password
    public function verifyUser($username, $password) {
        
        $this->setQueryParameter(array('username' => $username));
        if ($result = $this->modelSelect(2)) {
            if ($this->hashPassword($password) == $result['password']) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            $_GET['Fail'] = self::VERIFICATION_FAIL;
        }
    }
    
    //Adds user after checking if the same username already exists. Retutns true, if successfully added
    public function addUser(String $username, String $password, String $prename, String $name) {
        
        if ($this->userExist($username)) {
            $_GET['Fail'] = "This user is already exists";
            
            return FALSE;
        } else {
            $this->setQueryParameter(array('username' => $username, 'password' => $password, 'prename' => $prename, 'name' => $name));
            $this->modelInsert(1);
            
            return TRUE;
        }
    }
    
    public function deleteUser($id) {
        
        $this->setQueryParameter(array('id' => $id));
        $this->modelDelete(1);
    }
    
    public function updateUser($id, $username = "", $password = "", $prename = "", $name = "") {
        
        if (!($username == "") && !$this->userExist($username)) {
            $this->setQueryParameter(array('id' => $id, 'username' => $username));
            $this->modelUpdate(1);
        } else {
            $_GET['This username exists already'];
        }
        if (!($password == "")) {
            $this->setQueryParameter(array('id' => $id, 'password' => $password));
            $this->modelUpdate(2);
        }
        if (!($prename == "")) {
            $this->setQueryParameter(array('id' => $id, 'prename' => $prename));
            $this->modelUpdate(3);
        }
        if (!($name == "")) {
            $this->setQueryParameter(array('id' => $id, 'name' => $name));
            $this->modelUpdate(4);
        }
    }
    
    private function modelSelect(Integer $whichSelectStatement) {
        // TODO: Implement modelSelect() method.
        switch ($whichSelectStatement) {
            case 1: //SELECT user by his name
                return $this->database->performQuery(self, self::GET_USER_BY_NAME);
            case 2: //Get password hash by username for verification
                return $this->database->performQuery(self, self::GET_PASSWORD_HASH);
            default:
                $_GET['Fail'] = self::QUERY_FAIL;
                break;
        }
    }
    
    private function modelInsert(Integer $whichInsertStatement) {
        // TODO: Implement modelInsert() method.
        switch ($whichInsertStatement) {
            case 1:
                $this->database->performQuery(self, self::ADDUSER);
                break;
            default:
                $_GET['Fail'] = self::QUERY_FAIL;
                break;
        }
    }
    
    //Database communication
    private function modelUpdate(Integer $whichUpdateStatement) {
        // TODO: Implement modelUpdate() method.
        switch ($whichUpdateStatement) {
            case 1:
                $this->database->performQuery(self, self::UPDATE_USERNAME);
                break;
            case 2:
                $this->database->performQuery(self, self::UPDATE_PASSWORD);
                break;
            case 3:
                $this->database->performQuery(self, self::UPDATE_PRENAME);
                break;
            case 4:
                $this->database->performQuery(self, self::UPDATE_NAME);
                break;
            default:
                $_GET['Fail'] = self::QUERY_FAIL;
                break;
        }
    }
    
    private function modelDelete(Integer $whichDeleteStatement) {
        // TODO: Implement modelDelete() method.
        switch ($whichDeleteStatement) {
            case 1:
                $this->database->performQuery(self, self::DELETE_USER_BY_ID);
                break;
            default:
                $_GET['Fail'] = self::QUERY_FAIL;
                break;
        }
    }
    
    //checks if a user exists or not
    private function userExist($username) {
        
        $result = $this->modelSelect(1);
        if ($result['username'] == "" || empty($result['username'])) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    //Hashs the password and returns it
    private function hashPassword($passwordClear) {
        
        return password_hash($passwordClear, PASSWORD_DEFAULT);
    }
}