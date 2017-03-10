<?php

/**
 * User: Emaro
 * Date: 03.03.2017
 * Time: 10:53
 */

require_once 'mvc/Controller/View.php'; // Relative to index.php

class Controller {
    
    public function __construct($uViewId) {
        
        $view = new View($uViewId);
        $view->show();
    }
}