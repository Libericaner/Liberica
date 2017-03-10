<?php

/**
 * User: Emaro
 * Date: 03.03.2017
 * Time: 10:53
 */
class Controller {
    
    
    public function __construct($view) {
        
        $this->views = glob(View::PATTERN); // Get all view.php file names
        $this->showView($view);
    }
    
    
    public function showView($uView) {
    
        /** @noinspection PhpUnusedLocalVariableInspection */
        $sView = htmlentities($uView); // Used to output the view name in views
        
        // TODO: print head
        
        // TODO: print menu
        
        $path = $this->getValidViewPath($uView);
        /** @noinspection PhpIncludeInspection */
        include $path;
    }
    
    private function getValidViewPath($view) {
        
        $path = $this->getViewPath($view);
        $viewExists = in_array($path, $this->views);
        
        if ($viewExists) {
            return $path;
        }
        
        return $this->getViewPath(View::ERROR);
    }
    
    private function getViewPath($view) {
        
        return View::LOCATION . $view . View::SUFFIX;
    }
}