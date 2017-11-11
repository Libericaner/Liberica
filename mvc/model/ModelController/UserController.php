<?php
/**
 * User: joel-haeberli
 * Date: 11.11.17
 * Time: 12:56
 */

class UserController
{
    //Verifys a user by his username and password
    public static function verifyUser($email, $password) {

        if (self::userExist($email)) {
            self::setQueryParameter(array('email' => $email));
            if ($user = self::modelSelect(self::SELECT_PASSWORD_HASH_STATEMENT)) {
                return password_verify($password, $user->getPassword());
            }
            else {
                self::$fails = self::VERIFICATION_FAIL;
            }
        } else {
            self::$fails = self::VERIFICATION_FAIL;
            return FALSE;
        }
        return FALSE;
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
            self::setQueryParameter(array('id' => $id, 'email' => $email));
            self::modelUpdate(self::UPDATE_USERNAME_STATEMENT);
        }

        if (!($password == NULL)) {
            self::setQueryParameter(array('id' => $id, 'password' => $password));
            self::modelUpdate(self::UPDATE_PASSWORD_STATEMENT);
        }
    }

    public static function getFail() {

        return self::$fails;
    }
}