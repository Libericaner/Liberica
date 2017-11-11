<?php
/**
 * User: joel-haeberli
 * Date: 11.11.17
 * Time: 14:25
 */

class Tag
{
    private $id;
    private $label;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getLabel()
    {
        return $this->label;
    }
    public function setLabel($label)
    {
        $this->label = $label;
    }
}