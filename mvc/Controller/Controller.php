<?php

/**
 * User: Emaro
 * Date: 03.03.2017
 * Time: 10:53
 */

const MVC_CONTROLLER = 'mvc/Controller/';

require_once MVC_CONTROLLER . 'View.php'; // Relative to index.php
require_once MVC_CONTROLLER . 'file.php';

require_once 'mvc/database/DBConnection.php';

require_once MVC_CONTROLLER . 'commands.php';


class Controller {
    
    public function __construct($uViewId) {
        
        if (!isset($_POST['sub']))
            $u = 'NULL'; // TODO: bad fallback value
        else
            $u = $this->run($_POST['sub']);
        
        
        $view = new View($uViewId);
        $view->show($u);
    }
    
    private function run($form) {
        
        foreach ($form as $k => $v) {
            $f = 'X' . $k;
            if (function_exists($f))
            {
                return $f();
            }
            return 'Nicht erkannt';
        }
    }
}