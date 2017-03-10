<?php

/**
 * User: Joel Häberli
 * Date: 10.03.2017
 * Time: 10:39
 */
interface Queryable {
    
    //welches Statement wird ausgeführt? -> im Model definierte Switch-Struktur, welche auf Konstante QueryPattern zugrifff haben.
    public function modelSelect(Integer $whichSelectStatement);
    
    public function modelInsert(Integer $whichInsertStatement);
    
    public function modelUpdate(Integer $whichUpdateStatement);
    
    public function modelDelete(Integer $whichDeleteStatement);
    
    //Welche Bedingungen,Spalten oder andere SQL-Commands müssen beachtet werden, wenn man die Query ausfüfhrt -> assoziatives array -> array("where"=>$where,"equals"=>$equals
    //http://php.net/manual/de/pdostatement.execute.php
    public function getQueryParameter();
    
    public function setQueryParameter(Array $params);
}