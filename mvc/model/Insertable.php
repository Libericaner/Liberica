<?php

/**
 * Created by PhpStorm.
 * User: Joel Häberli
 * Date: 03.03.2017
 * Time: 10:46
 */
interface Insertable {
    
    public function setInsertKeys(Array $keys);
    
    public function setInsertValues(Array $values);
    
    public function performInsert();
}