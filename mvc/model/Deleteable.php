<?php

/**
 * Created by PhpStorm.
 * User: Joel Häberli
 * Date: 03.03.2017
 * Time: 10:45
 */
interface Deleteable {
    
    public function setIdToDelete(Integer $id);
    
    public function performDelete();
}