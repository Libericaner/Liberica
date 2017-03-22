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
        
        if (isset($_POST['command']))
            $this->run($_POST['command']);
        
        $u = FALSE;
        if (isset($_POST['register']))
        {
            $u =  "USER";
        }
        
        $view = new View($uViewId);
        $view->show($u);
    }
    
    private function run($uCommand) {
        
        if (empty($uCommand))
            return;
        
        switch ($uCommand) {
            case 'save-string':
                fileAppend($_POST['data']);
        }
    }
}