<?php

/**
 * User: Emaro
 * Date: 03.03.2017
 * Time: 10:53
 */

require_once 'mvc/Controller/View.php'; // Relative to index.php
require_once 'mvc/Controller/file.php';




function XsaveTextToFile() {
    
    fileAppend($_POST['data']);
    return 'saved in file: ' . $_POST['data'];
}

function XregisterUser() {
    
    return 'User "' . $_POST['name'] . '" registered';
}

function XtoHome() {
    
    header('Location: ./?view=home');
    exit;
}


class Controller {
    
    public function __construct($uViewId) {
        
        if (!isset($_POST['sub']))
            $u = 'NULL';
        else
            $u = $this->run($_POST['sub']);
        
        
        $view = new View($uViewId);
        $view->show($u);
    }
    
    private function run($cmd) {
        
        return $this->_run($cmd);
    }
    
    private function _run($form) {
        var_dump($form);
        foreach ($form as $k => $v) {
            $f = 'X' . $k;
            return $f();
        }
    }
}