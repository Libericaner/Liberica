<?php

/**
 * User: Emaro
 * Date: 2017-03-10
 * Time: 11:19
 */
class View {
    
    const SUFFIX   = '.view.php';
    const LOCATION = 'mvc/Views/'; // Relative to index.php
    const PATTERN  = self::LOCATION . '*' . self::SUFFIX;
    const ERROR    = '404';
    
    
    public static function getViewPath($view) {
        
        return self::LOCATION . $view . self::SUFFIX;
    }
    
    public static function get404Path() {
        
        return self::getViewPath(self::ERROR);
    }
}