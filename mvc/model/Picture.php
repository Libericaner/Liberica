<?php

/**
 * User: Joel Häberli
 * Date: 17.03.2017
 * Time: 08:44
 */
class Picture extends Model {
    
    private $id;
    private $tag;
    private $title;
    private $picture_blob;
    private $thumbnail_blob;
    private $picture_ploc;
    private $thumbnail_ploc;
    
    private $galleryId;
    
    //TODO : create query-pattern
    const GET_PICTURE_BLOB_BY_ID = "SELECT id, tag, title, picture_blob, thumbnail_blob FROM pic WHERE id = :id;";
    const GET_PICTURES_BLOB_BY_GALLERY_ID = "SELECT P.id, P.tag, P.title, P.picture_blob, P.thumbnail_blob FROM pic AS P INNER JOIN gallery_pic AS GP ON P.id = GP.pic_id INNER JOIN gallery AS G ON G.id = GP.gallery_id WHERE G.id = :idGallery;";
    const GET_X_PICTURES_BLOB = "SELECT id, tag, title, picture_blob, picture_thumbnail FROM pic ORDER BY id DESC LIMIT :num;";
    const GET_LAST_CREATED_PICTURE_ID_FOR_GALLERY_CONSTRAINT = "SELECT id from pic ORDER BY id DESC LIMIT 1";
    
    const ADD_PICTURE = "INSERT INTO pic (tag, title, picture_blob, thumbnail_blob) VALUES (:tag, :title, :picture_blob, :thumbnail_blob);";
    const ADD_GALLERY_CONSTRAINT = "INSERT INTO gallery_pic (gallery_id, pic_id) VALUES (:galleryId, :picId)";
    
    public function __construct($galleryId = null, $id = null, $tag = null, $title = null, $pictureUnconverted = null, $thumbnailUnconverted = null) {
        $this->galleryId = $galleryId;
        $this->id = $id;
        $this->tag = $tag;
        $this->title = $title;
        $this->picture_blob = $this->picToBlob($pictureUnconverted);
        $this->thumbnail_blob = $this->picToBlob($thumbnailUnconverted);
    }
    
    public function addPicture($galleryId, $tag, $title, $pictureUnconverted, $thumbnailUnconverted) {
        
        self::setQueryParameter(array('tag'=>$tag,'title'=>$title,'picture_blob'=>$this->picToBlob($pictureUnconverted),'thumbnail_blob'=>$this->picToBlob($thumbnailUnconverted)));
        self::modelInsert(self::ADD_PICTURE_STATEMENT);
        $newPicId = self::modelSelect(self::GET_LAST_CREATED_PICTURE_ID_FOR_GALLERY_CONSTRAINT_STATEMENT);
        self::setQueryParameter(array('galleryId' => $galleryId, 'picId' => $newPicId));
        self::modelInsert(self::ADD_GALLERY_CONSTRAINT_STATEMENT);
    }
    
    public function updatePicture() {
        
        
    }
    
    public function getPictureById(Integer $id) {
        
        self::setQueryParameter(array('id' => $id));
        return self::modelSelect(self::GET_PICTURES_BLOB_BY_GALLERY_ID_STATEMENT);
    }
    
    public function getPicturesFromGallery(Integer $idGallery) {
        
        self::setQueryParameter(array('idGallery' => $idGallery));
        return self::modelSelect(self::GET_PICTURES_BLOB_BY_GALLERY_ID_STATEMENT);
    }
    
    public function getNumberOfPictures(Integer $number) {
        
        self::setQueryParameter(array('num' => $number));
        self::modelSelect(self::GET_X_PICTURES_BLOB_STATEMENT);
    }
    
    private function picToBlob($pic) {
        
    }
    
    private function blobToPic($blob) {
        
    }
    
    const GET_PICTURES_BLOB_BY_ID_STATEMENT = 1;
    const GET_PICTURES_BLOB_BY_GALLERY_ID_STATEMENT = 2;
    const GET_X_PICTURES_BLOB_STATEMENT = 3;
    const GET_LAST_CREATED_PICTURE_ID_FOR_GALLERY_CONSTRAINT_STATEMENT = 4;
    
    private function modelSelect(Integer $whichSelectStatement) {
        $p = new Picture();
        switch($whichSelectStatement) {
            case self::GET_PICTURES_BLOB_BY_ID_STATEMENT:
                return;
            case self::GET_PICTURES_BLOB_BY_GALLERY_ID_STATEMENT:
                return;
            case self::GET_X_PICTURES_BLOB_STATEMENT:
                return;
            case self::GET_LAST_CREATED_PICTURE_ID_FOR_GALLERY_CONSTRAINT_STATEMENT:
                return;
            default:
                return;
        }
    }
    
    const ADD_PICTURE_STATEMENT = 1;
    const ADD_GALLERY_CONSTRAINT_STATEMENT = 2;
    
    private function modelInsert(Integer $whichInsertStatement) {
        // TODO: Implement modelInsert() method.
    }
    
    private function modelUpdate(Integer $whichUpdateStatement) {
        // TODO: Implement modelUpdate() method.
    }
    
    private function modelDelete(Integer $whichDeleteStatement) {
        // TODO: Implement modelDelete() method.
    }
}