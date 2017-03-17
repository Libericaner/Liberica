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
    public function __construct(Database $database = NULL) {
        
        if (!($database == NULL)) {
            $this->setDatabase($database);
        }
    }
    
    //Verifys a user by his username and password
    public function verifyUser($username, $password) {
        
        $this->setQueryParameter(array('username' => $username));
        if ($result = $this->modelSelect(self::SELECT_PASSWORD_HASH_STATEMENT)) {
            if ($this->hashPassword($password) == $result['password']) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            $_GET['Fail'] = self::VERIFICATION_FAIL;
        }
    }
    
    public function selectUserByName(String $username) {
        
        $this->setQueryParameter(array('username' => $username));
        
        return $this->modelSelect(self::SELECT_USER_BY_NAME_STATEMENT);
    }
    
    public function selectUserById(Integer $id) {
        
        $this->setQueryParameter(array('id' => $id));
        
        return $this->modelSelect(self::SELECT_USER_BY_ID_STATEMENT);
    }
    
    //Adds user after checking if the same username already exists. Retutns true, if successfully added
    public function addUser(String $username, String $password, String $prename, String $name) {
        
        if ($this->userExist($username)) {
            $_GET['Fail'] = "This user is already exists";
            
            return FALSE;
        } else {
            $this->setQueryParameter(array('username' => $username, 'password' => $password, 'prename' => $prename, 'name' => $name));
            $this->modelInsert(self::ADD_USER_STATEMENT);
            
            return TRUE;
        }
    }
    
    public function deleteUser($id) {
        
        $this->setQueryParameter(array('id' => $id));
        $this->modelDelete(self::DELETE_USER_BY_ID_STATEMENT);
    }
    
    public function updateUser($id, $username = "", $password = "", $prename = "", $name = "") {
        
        if (!($username == "") && !$this->userExist($username)) {
            $this->setQueryParameter(array('id' => $id, 'username' => $username));
            $this->modelUpdate(self::UPDATE_USERNAME_STATEMENT);
        } else {
            $_GET['This username exists already'];
        }
        if (!($password == "")) {
            $this->setQueryParameter(array('id' => $id, 'password' => $password));
            $this->modelUpdate(self::UPDATE_PASSWORD_STATEMENT);
        }
        if (!($prename == "")) {
            $this->setQueryParameter(array('id' => $id, 'prename' => $prename));
            $this->modelUpdate(self::UPDATE_PRENAME_STATEMENT);
        }
        if (!($name == "")) {
            $this->setQueryParameter(array('id' => $id, 'name' => $name));
            $this->modelUpdate(self::UPDATE_NAME_STATEMENT);
        }
    }
    
    //SELECT
    const SELECT_USER_BY_NAME_STATEMENT  = 1;
    const SELECT_PASSWORD_HASH_STATEMENT = 2;
    const SELECT_USER_BY_ID_STATEMENT    = 3;
    
    private function modelSelect(Integer $whichSelectStatement) {
        // TODO: Implement modelSelect() method.
        switch ($whichSelectStatement) {
            case self::SELECT_USER_BY_NAME_STATEMENT: //SELECT user by his name
                return $this->database->performQuery(self, self::GET_USER_BY_NAME);
            case self::SELECT_PASSWORD_HASH_STATEMENT: //Get password hash by username for verification
                return $this->database->performQuery(self, self::GET_PASSWORD_HASH);
            case self::SELECT_USER_BY_ID_STATEMENT:
                return $this->database->performQuery(self, self::GET_USER_BY_ID);
            default:
                $_GET['Fail'] = self::QUERY_FAIL;
                break;
        }
    }
    
    //INSERT
    const ADD_USER_STATEMENT = 1;
    
    private function modelInsert(Integer $whichInsertStatement) {
        // TODO: Implement modelInsert() method.
        switch ($whichInsertStatement) {
            case self::ADD_USER_STATEMENT:
                $this->database->performQuery(self, self::ADDUSER);
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
    
    private function modelUpdate(Integer $whichUpdateStatement) {
        // TODO: Implement modelUpdate() method.
        switch ($whichUpdateStatement) {
            case self::UPDATE_USERNAME_STATEMENT:
                $this->database->performQuery(self, self::UPDATE_USERNAME);
                break;
            case self::UPDATE_PASSWORD_STATEMENT:
                $this->database->performQuery(self, self::UPDATE_PASSWORD);
                break;
            case self::UPDATE_PRENAME_STATEMENT:
                $this->database->performQuery(self, self::UPDATE_PRENAME);
                break;
            case self::UPDATE_NAME_STATEMENT:
                $this->database->performQuery(self, self::UPDATE_NAME);
                break;
            default:
                $_GET['Fail'] = self::QUERY_FAIL;
                break;
        }
    }
    
    //DELETE
    const DELETE_USER_BY_ID_STATEMENT = 1;
    
    private function modelDelete(Integer $whichDeleteStatement) {
        // TODO: Implement modelDelete() method.
        switch ($whichDeleteStatement) {
            case self::DELETE_USER_BY_ID_STATEMENT:
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