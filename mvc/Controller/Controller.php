<?php

/**
 * User: Emaro
 * Date: 03.03.2017
 * Time: 10:53
 */

require_once 'mvc/Controller/View.php'; // Relative to index.php
require_once 'mvc/Controller/file.php';

class Controller {
    
    public function __construct($uViewId) {
        
        if (isset($_POST['command'])) {
            $cmd = $_POST['command'];
            
            if (!empty($cmd) && $cmd == 'save-string') {
                $data = $_POST['data'];
                if (isset($data) && !empty($data))
                    fileAppend($data);
            }
        }
        
        
        $view = new View($uViewId);
        $view->show();
    }
}