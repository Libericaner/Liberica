<?php

/**
 * User: Emaro
 * Date: 03.03.2017
 * Time: 10:53
 */
class Controller {
    
    const DEFAULT_VIEW = '404';
    
    private $viewsLocation = 'mvc/Views/';
    private $viewSuffix    = '.view.php';
    private $viewPattern   = 'mvc/Views/*.view.php';
    
    
    public function __construct($view) {
        
        $this->views = glob($this->viewPattern); // Get all view.php file names
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
        
        return $this->getViewPath(self::DEFAULT_VIEW);
    }
    
    private function getViewPath($view) {
        
        return $this->viewsLocation . $view . $this->viewSuffix;
    }
}