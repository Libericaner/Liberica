<?php

/**
 * User: Joel Häberli
 * Date: 17.03.2017
 * Time: 08:43
 */
class Gallery extends Model {
    
    // TODO : solve static - unstatic problem -> static access not possible cause of the Databaseconnection from the parent-class "Model" (db-connection is not static)
    
    private $idGallery;
    private $galleryName;
    
    //TODO : create query-pattern
    const GET_GALLERY_BY_ID = "SELECT galleryName FROM gallery WHERE idGallery = :idGallery";
    
    const ADD_NEW_GALLERY = "INSERT INTO gallery (galleryName) VALUES (:galleryName)";
    
    const UPDATE_GALLERY_NAME = "UPDATE gallery SET galleryName = :galleryName";
    
    //FAILS
    const QUERY_FAIL = "We could not find this query";
    
    public function addGallery(String $galleryName) {
        
        $gallery = new Gallery();
        $gallery->setQueryParameter(array('galleryName' => $galleryName));
    }
    
    public function getGalleryById(Integer $id) {
        
        $this->setQueryParameter(array('idGallery' => $id));
        
    }
    
    const GET_GALLERY_BY_ID_STATEMENT = 1;
    
    private function modelSelect(Integer $whichSelectStatement) {
        // TODO: Implement modelSelect() method.
        switch ($whichSelectStatement) {
            case self::GET_GALLERY_BY_ID_STATEMENT:
                return $this->database->performQuery(self, self::GET_GALLERY_BY_ID);
            default:
                $_GET['Fail'] = self::QUERY_FAIL;
                break;
        }
    }
    
    const ADD_NEW_GALLERY_STATEMENT = 1;
    
    private function modelInsert(Integer $whichInsertStatement) {
        // TODO: Implement modelInsert() method.
        switch ($whichInsertStatement) {
            case self::ADD_NEW_GALLERY_STATEMENT:
                return $this->database->performQuery(self, self::GET_GALLERY_BY_ID);
            default:
                $_GET['Fail'] = self::QUERY_FAIL;
                break;
        }
    }
    
    private function modelUpdate(Integer $whichUpdateStatement) {
        // TODO: Implement modelUpdate() method.
        switch ($whichUpdateStatement) {
            default:
                $_GET['Fail'] = self::QUERY_FAIL;
                break;
        }
    }
    
    private function modelDelete(Integer $whichDeleteStatement) {
        // TODO: Implement modelDelete() method.
        switch ($whichDeleteStatement) {
            default:
                $_GET['Fail'] = self::QUERY_FAIL;
                break;
        }
    }
}