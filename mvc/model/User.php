<?php

/**
 * User: Joel Häberli
 * Date: 17.03.2017
 * Time: 08:43
 */

require_once "mvc/Model/Model.php";

class User extends Model {
    
    private $id;
    private $email;
    private $password;
    
    const GET_USER_BY_NAME = "SELECT id, email FROM user WHERE email = :email LIMIT 1;";
    const GET_USER_BY_ID   = "SELECT email FROM user WHERE id = :id;";
    const ADD_USER         = "INSERT INTO user (email, password) VALUES (:email, :password);";
    
    const GET_PASSWORD_HASH = "SELECT password FROM user WHERE email = :email LIMIT 1;";
    
    const UPDATE_USERNAME = "UPDATE user SET email = :email WHERE id = :id;";
    const UPDATE_PASSWORD = "UPDATE user SET password = :password WHERE id = :id;";
    
    const DELETE_USER_BY_ID = "DELETE FROM user WHERE id = :id;";
    
    //You can initialize a user
    public function __construct($id = NULL, $email = NULL, $password = NULL) {
        
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
    }
    
    //Abstract method from Model
    public static function getObjects($result) {
        
        $entries = count($result);
        
        if ($entries <= 0)
            return null;
        if ($entries == 1)
            return new User($result['id'], $result['email'], $result['password']);
        if ($entries > 1) {
            $users = array();
            foreach ($result as $entry) {
                array_push($users, new User($entry['id'], $entry['email'], $entry['password']));
            }
            return $users;
        }
    }
    
    //Verifys a user by his username and password
    public static function verifyUser($email, $password) {
        
        if (self::userExist($email)) {
            $user = Model::query('User', array('email' => $email), self::SELECT_PASSWORD_HASH_STATEMENT);
            if (!empty($user->getPassword())) {
                return password_verify($password, $user->getPassword());
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
        return FALSE;
    }
    
    public static function getUserByEmail($email) {
        return Model::query('User', array('email' => $email), self::SELECT_USER_BY_NAME_STATEMENT);
    }
    
    public static function getUserById($id) {
        return Model::query('User', array('id' => $id), self::SELECT_USER_BY_ID_STATEMENT);
    }
    
    //Adds user after checking if the same username already exists. Retutns true, if successfully added
    public static function addUser($email, $password) {
        
        if (self::userExist($email)) {
            return FALSE;
        }
        else {
            Model::query(array('email' => $email, 'password' => self::hashPassword($password)), self::ADD_USER_STATEMENT);
            return TRUE;
        }
    }
    
    public static function deleteUser($id) {
        Model::query(array('id' => $id),self::DELETE_USER_BY_ID_STATEMENT);
    }
    
    public function updateUser($id, $email = NULL, $password = NULL) {
        
        if (!($email == NULL) && !self::userExist($email)) {
            Model::query(array('id' => $id, 'email' => $email),self::UPDATE_USERNAME_STATEMENT);
        }
        
        if (!($password == NULL)) {
            Model::query(array('id' => $id, 'password' => $password),self::UPDATE_PASSWORD_STATEMENT);
        }
    }
    
    //checks if a user exists or not
    private static function userExist($email) {
    
        $user = Model::query('User', array('email' => $email), self::SELECT_USER_BY_NAME_STATEMENT);
        if ($user != NULL && !($user->getEmail() == NULL)) {
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
        
        return htmlentities($this->id);
    }
    
    public function getEmail() {
        
        return htmlentities($this->email);
    }
    
    public function getPrename() {
        
        return $this->prename;
    }
    
    public function getName() {
        
        return htmlentities($this->name);
    }
    
    public function getPassword() {
        
        return htmlentities($this->password);
    }
}
