<?php

/**
 * User: Emaro
 * Date: 03.03.2017
 * Time: 10:53
 */

const MVC_CONTROLLER = 'mvc/Controller/';

require_once MVC_CONTROLLER . 'library.php';

require_once MVC_CONTROLLER . 'View.php'; // Relative to index.php
require_once MVC_CONTROLLER . 'file.php';

require_once 'mvc/Database/DBConnection.php';

require_once MVC_CONTROLLER . 'commands.php';


class Controller {
    
    public function __construct() {
    
        $uViewId = DEFAULT_PAGE;
    
        if (isset($_GET['view']))
            $uViewId = $_GET['view'];
        
        if (in_array($uViewId, PUBLIC_VIEWS))
            redirectUser();
        else
            redirectGuest();
        
        if (!isset($_POST['sub']))
            $u = '';
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
        
        return 'Es ist ein Fehler aufgetreten';
    }
}