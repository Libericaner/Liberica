<?php

/**
 * User: Emaro
 * Date: 03.03.2017
 * Time: 10:53
 */
class Controller {
    
    const DEFAULT_VIEW = 'home';
    
    public function __construct($view) {
        
        $this->showView($view);
    }
    
    public function showView($view) {
        
        if (!isset($view)) { // TODO: make sure, view is not empty and a valid view
            $view = self::DEFAULT_VIEW;
        }
        include('Views/' . $view . '.php');
    }
}