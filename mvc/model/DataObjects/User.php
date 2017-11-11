<?php
/**
 * User: joel-haeberli
 * Date: 11.11.17
 * Time: 14:27
 */

class User
{
    private $id;
    private $email;
    private $password;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
}