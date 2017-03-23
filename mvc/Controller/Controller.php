<?php

/**
 * User: Emaro
 * Date: 03.03.2017
 * Time: 10:53
 */

require_once 'mvc/Controller/View.php'; // Relative to index.php
require_once 'mvc/Controller/file.php';

$u;

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
        
        if (isset($cmd['file'])) {
            
            fileAppend($_POST['data']);
            return 'saved in file: ' . $_POST['data'];
        }
        elseif (isset($cmd['register'])) {
            
            return 'User "' . $_POST['name'] . '" registered';
        }
        elseif (isset($cmd['redir'])) {
            
            header('Location: ./?view=home');
            exit;
        }
    }
}