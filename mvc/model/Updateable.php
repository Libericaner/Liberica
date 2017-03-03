<?php

/**
 * Created by PhpStorm.
 * User: Joel Häberli
 * Date: 03.03.2017
 * Time: 10:45
 */
interface Updateable {
    
    public function setUpdateKeys(Array $keys);
    
    public function setUpdateValues(Array $values);
    
    public function performUpdate();
}