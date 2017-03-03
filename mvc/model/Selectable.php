<?php

/**
 * Created by PhpStorm.
 * User: Joel Häberli
 * Date: 03.03.2017
 * Time: 10:44
 */
interface Selectable {
    
    public function setSelectors(Array $selectors);
    
    public function setConditions(Array $conditions);
    
    public function performSelect();
}