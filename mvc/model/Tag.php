<?php

/**
 * User: Joel Häberli
 * Date: 17.03.2017
 * Time: 08:43
 */
class Tag implements Queryable {
    
    //TODO : create query-pattern
    
    public function modelSelect(Integer $whichSelectStatement) {
        
        switch ($whichSelectStatement) {
            case 1:
                //Select all tags (example)
                break;
        }
    }
    
    public function modelInsert(Integer $whichInsertStatement) {
        // TODO: Implement modelInsert() method.
    }
    
    public function modelUpdate(Integer $whichUpdateStatement) {
        // TODO: Implement modelUpdate() method.
    }
    
    public function modelDelete(Integer $whichDeleteStatement) {
        // TODO: Implement modelDelete() method.
    }
    
    public function getQueryParameter() {
        // TODO: Implement getQueryParameter() method.
    }
    
    public function setQueryParameter(Array $params) {
        // TODO: Implement setQueryParameter() method.
    }
}