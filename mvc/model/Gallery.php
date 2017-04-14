<?php

/**
 * User: Joel Häberli
 * Date: 17.03.2017
 * Time: 08:43
 */
class Gallery extends Model {
    
    private $id;
    private $name;
    private $description;
    
    const GET_GALLERY_BY_ID = "SELECT name, description FROM gallery WHERE id = :idGallery";
    
    const ADD_NEW_GALLERY = "INSERT INTO gallery (name) VALUES (:galleryName)";
    
    const UPDATE_GALLERY_NAME = "UPDATE gallery SET name = :galleryName";
    const UPDATE_GALLERY_DESCRIPTION = "UPDATE gallery SET description = :galleryDescription";
    
    const DELET_GALLERY_NAME = "DELETE FROM gallery WHERE id = :id";
    
    //FAILS
    const QUERY_FAIL = "We could not find this query";
    
    public function __construct($id = NULL, $name = NULL, $description = NULL) {
        
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }
    
    public function addGallery(String $name, String $description) {
        
        self::setQueryParameter(array('galleryName' => $name, 'galleryDescription' => $description));
        self::modelInsert(self::ADD_NEW_GALLERY_STATEMENT);
    }
    
    public function getGalleryById(Integer $id) {
        
        self::setQueryParameter(array('idGallery' => $id));
        self::modelSelect(self::GET_GALLERY_BY_ID_STATEMENT);
    }
    
    public function deleteGalleryById(Integer $id) {
        
        self::setQueryParameter(array('id' => $id));
        self::modelDelete(self::DELETE_GALLERY_BY_ID_STATEMENT);
    }
    
    public function updateGallery(String $name = NULL, String $description = NULL) {
        if (!($name == NULL)) {
            self::setQueryParameter(array('galleryName' => $name));
            self::modelUpdate(self::UPDATE_NAME_STATEMENT);
        }
        if (!($description == NULL)) {
            self::setQueryParameter(array('galleryDescription' => $description));
            self::modelUpdate(self::UPDATE_DESCRIPTION_STATEMENT);
        }
    }
    
    const GET_GALLERY_BY_ID_STATEMENT = 1;
    
    private static function modelSelect(Integer $whichSelectStatement) {
        $g = new Gallery();
        switch ($whichSelectStatement) {
            case self::GET_GALLERY_BY_ID_STATEMENT:
                $result = self::$database->performQuery($g, self::GET_GALLERY_BY_ID);
                
                return new Gallery($result[0]['id'], $result[0]['name'], $result[0]['description']);
            default:
                $_GET['Fail'] = self::QUERY_FAIL;
                break;
        }
    }
    
    const ADD_NEW_GALLERY_STATEMENT = 1;
    
    private static function modelInsert(Integer $whichInsertStatement) {
        $g = new Gallery();
        switch ($whichInsertStatement) {
            case self::ADD_NEW_GALLERY_STATEMENT:
                return self::$database->performQuery($g, self::GET_GALLERY_BY_ID);
            default:
                $_GET['Fail'] = self::QUERY_FAIL;
                break;
        }
    }
    
    const UPDATE_NAME_STATEMENT = 1;
    const UPDATE_DESCRIPTION_STATEMENT = 2;
    
    private static function modelUpdate(Integer $whichUpdateStatement) {
        
        $g = new Gallery();
        switch ($whichUpdateStatement) {
            case self::UPDATE_NAME_STATEMENT:
                self::$database->performQuery($g, self::UPDATE_GALLERY_NAME);
                break;
            case self::UPDATE_DESCRIPTION_STATEMENT:
                self::$database->performQuery($g, self::UPDATE_GALLERY_DESCRIPTION);
                break;
            default:
                $_GET['Fail'] = self::QUERY_FAIL;
                break;
        }
    }
    
    const DELETE_GALLERY_BY_ID_STATEMENT = 1;
    
    private static function modelDelete(Integer $whichDeleteStatement) {
        
        $g = new Gallery();
        switch ($whichDeleteStatement) {
            case self::DELETE_GALLERY_BY_ID_STATEMENT:
                self::$database->performQuery($g, self::DELET_GALLERY_NAME);
                break;
            default:
                $_GET['Fail'] = self::QUERY_FAIL;
                break;
        }
    }
}