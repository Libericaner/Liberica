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
    private $picture_ploc; // What is ploc?
    private $thumbnail_ploc; // Same
    
    private $picture;
    private $thumbnail;
    
    private $galleryId;
    
    //TODO : create query-pattern
    const GET_PICTURE_BLOB_BY_ID = "SELECT id, tag, title, picture_blob, thumbnail_blob FROM pic WHERE id = :id;";
    const GET_PICTURES_BLOB_BY_GALLERY_ID = "SELECT P.id, P.tag, P.title, P.picture_blob, P.thumbnail_blob FROM pic AS P INNER JOIN gallery_pic AS GP ON P.id = GP.pic_id INNER JOIN gallery AS G ON G.id = GP.gallery_id WHERE G.id = :idGallery;";
    const GET_X_PICTURES_BLOB = "SELECT id, tag, title, picture_blob, picture_thumbnail FROM pic ORDER BY id DESC LIMIT :num;";
    const GET_LAST_CREATED_PICTURE_ID_FOR_GALLERY_CONSTRAINT = "SELECT id from pic ORDER BY id DESC LIMIT 1";
    
    const ADD_PICTURE = "INSERT INTO pic (tag, title, picture_blob, thumbnail_blob) VALUES (:tag, :title, :picture_blob, :thumbnail_blob);";
    const ADD_GALLERY_CONSTRAINT = "INSERT INTO gallery_pic (gallery_id, pic_id) VALUES (:galleryId, :picId)";
    
    const UPDATE_TAG = "UPDATE gallery SET tag = :tag WHERE id = :id;";
    const UPDATE_TITLE = "UPDATE gallery SET title = :title WHERE id = :id;";
    
    const DELETE_GALLERY_BY_ID = "DELETE FROM gallery WHERE id = :id";
    
    public function __construct($galleryId = null, $id = null, $tag = null, $title = null, $pictureUnconverted = null, $thumbnailUnconverted = null) {
        $this->galleryId = $galleryId;
        $this->id = $id;
        $this->tag = $tag;
        $this->title = $title;
        $this->picture_blob = $this->picToBlob($pictureUnconverted);
        $this->thumbnail_blob = $this->picToBlob($thumbnailUnconverted);
    }
    
    // Static?
    public function addPicture($galleryId, $tag, $title, $pictureUnconverted, $thumbnailUnconverted) {
        
        self::setQueryParameter(array('tag'=>$tag,'title'=>$title,'picture_blob'=>$this->picToBlob($pictureUnconverted),'thumbnail_blob'=>$this->picToBlob($thumbnailUnconverted)));
        self::modelInsert(self::ADD_PICTURE_STATEMENT);
        $newPicId = self::modelSelect(self::GET_LAST_CREATED_PICTURE_ID_FOR_GALLERY_CONSTRAINT_STATEMENT);
        self::setQueryParameter(array('galleryId' => $galleryId, 'picId' => $newPicId));
        self::modelInsert(self::ADD_GALLERY_CONSTRAINT_STATEMENT);
    }
    
    public function updatePicture($id, $tag = null, $title = null) {
        
        $updated = false;
        
        if (isset($tag)) {
            self::setQueryParameter(array('id' => $id, 'tag' => $tag));
            self::modelUpdate(self::UPDATE_TAG_STATEMENT);
            $updated = true;
            // TODO: Don't set $updated always to true - this info doesn't help anybody
            // Because you should know if $tag is null or not
        }
        if (isset($title)) {
            self::setQueryParameter(array('id' => $id, 'title' => $title));
            self::modelUpdate(self::UPDATE_TITLE_STATEMENT);
            $updated = true;
        }
        return $updated;
    }
    
    // Static!
    public function getPictureById(Integer $id) {
        
        self::setQueryParameter(array('id' => $id));
        return self::modelSelect(self::GET_PICTURES_BLOB_BY_GALLERY_ID_STATEMENT);
    }
    
    // Static and consider moving to gallery class
    public function getPicturesFromGallery(Integer $idGallery) {
        
        self::setQueryParameter(array('idGallery' => $idGallery));
        return self::modelSelect(self::GET_PICTURES_BLOB_BY_GALLERY_ID_STATEMENT);
    }
    
    // Static!
    // Of all? Or from a specific user? The parameter represents what?
    public function getNumberOfPictures(Integer $number) {
        
        self::setQueryParameter(array('num' => $number));
        self::modelSelect(self::GET_X_PICTURES_BLOB_STATEMENT);
    }
    
    // Static!
    public function picToBlob($pic) {
        //should return the pic as blob
    }
    
    // Static
    public function blobToPic($blob) {
        //should return the blob as pic
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
    
    // ?
    private function resultToPicturesArray($result) {
        $pics = array();
        foreach ($result as $pic) {
            $p = new Picture();
            
            $p->setPicture($p->blobToPic($pic['picture_blob']));
            $p->setThumbnail($p->blobToPic($pic['thumbnail_blob']));
            $p->setTag($pic['tag']);
            $p->setTitle($pic['title']);
            $p->setId($pic['id']);
            
            $pics[] = $p;
        }
    }
    
    const ADD_PICTURE_STATEMENT = 1;
    const ADD_GALLERY_CONSTRAINT_STATEMENT = 2;
    
    private function modelInsert(Integer $whichInsertStatement) {
        $p = new Picture();
        switch ($whichInsertStatement) {
            case self::ADD_PICTURE_STATEMENT:
                self::$database->performQuery($p, self::ADD_PICTURE);
                
                return true;
            case self::ADD_GALLERY_CONSTRAINT_STATEMENT:
                self::$database->performQuery($p, self::ADD_GALLERY_CONSTRAINT);
    
                return true;
            default:
                return false;
        }
    }
    
    const UPDATE_TAG_STATEMENT = 1;
    const UPDATE_TITLE_STATEMENT = 2;
    
    private function modelUpdate(Integer $whichUpdateStatement) {
        $p = new Picture();
        switch($whichUpdateStatement) {
            case self::UPDATE_TAG_STATEMENT:
                self::$database->performQuery($p, self::UPDATE_TAG);
                return true;
            case self::UPDATE_TITLE_STATEMENT:
                self::$database->performQuery($p, self::UPDATE_TITLE);
                return true;
            default:
                return false;
        }
    }
    
    const DELETE_GALLERY_BY_ID_STATEMENT = 1;
    
    private function modelDelete(Integer $whichDeleteStatement) {
        $p = new Picture();
        switch ($whichDeleteStatement) {
            case self::DELETE_GALLERY_BY_ID_STATEMENT:
                self::$database->performQuery($p, self::DELETE_GALLERY_BY_ID);
                return true;
            default:
                return false;
        }
    }
    
    public function getId() {
        
        return $this->id;
    }
    
    public function setId($id) {
        
        $this->id = $id;
    }
    
    public function getTag() {
        
        return $this->tag;
    }
    
    public function setTag($tag) {
        
        $this->tag = $tag;
    }
    
    public function getTitle() {
        
        return $this->title;
    }
    
    public function setTitle($title) {
        
        $this->title = $title;
    }
    
    public function getPictureBlob() {
        
        return $this->picture_blob;
    }
    
    public function setPictureBlob($picture_blob) {
        
        $this->picture_blob = $picture_blob;
    }
    
    public function getThumbnailBlob() {
        
        return $this->thumbnail_blob;
    }
    
    public function setThumbnailBlob($thumbnail_blob) {
        
        $this->thumbnail_blob = $thumbnail_blob;
    }
    
    public function getPicture() {
        
        return $this->picture;
    }
    
    public function setPicture($picture) {
        
        $this->picture = $picture;
    }
    
    public function getThumbnail() {
        
        return $this->thumbnail;
    }
    
    public function setThumbnail($thumbnail) {
        
        $this->thumbnail = $thumbnail;
    }
}