<?php

session_start();

/**
 * User: Emaro
 * Date: 2017-03-10
 * Time: 11:19
 */

require_once "mvc/Controller/printLib.php";

class View {
    
    const SUFFIX   = '.view.php';
    const LOCATION = 'mvc/Views/'; // Relative to index.php
    const PATTERN  = self::LOCATION . '*' . self::SUFFIX;
    const ERROR    = '404';
    
    const NO404FOUND = 'Kein gültiger Pfad und 404 View wurde nicht gefunden';
    
    private static $VIEWS;
    
    
    public function __construct($uId) {
        
        $this->sId = htmlentities($uId);
    }
    
    
    public function show($arg) {
        
        
        printHead();
        
        printMenu();
        
        /** @noinspection PhpIncludeInspection */
        include $this->getValidViewPath($this->sId);
        
        printFoot();
    }
    
    private function getValidViewPath($view) {
        
        self::refreshViewList();
        
        $path = View::getViewPath($view);
        $viewExists = in_array($path, self::$VIEWS);
        
        if ($viewExists)
            return $path;
        
        return View::get404Path();
    }
    
    public static function refreshViewList() {
        
        self::$VIEWS = glob(self::PATTERN);
    }
    
    public static function getViewPath($view) {
        
        return self::LOCATION . $view . self::SUFFIX;
    }
    
    public static function get404Path() {
        
        $errorPath = self::getViewPath(self::ERROR);
        
        if (!is_file($errorPath))
            die(self::NO404FOUND);
        
        return $errorPath;
    }
}