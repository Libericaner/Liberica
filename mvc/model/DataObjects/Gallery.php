<?php
/**
 * User: joel-haeberli
 * Date: 11.11.17
 * Time: 14:06
 */

class Gallery
{
    private $id;
    private $name;
    private $description;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
}