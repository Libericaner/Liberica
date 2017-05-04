<?php

/**
 * User: Joel Häberli
 * Date: 17.03.2017
 * Time: 08:44
 */

define("PICTURENAME_IN_FILES_ARRAY", "picture");
define("THUMBNAIL_SIZE", 192);

class Picture extends Model {
    
    private $id;
    private $tag;
    private $title;
    private $picture_blob;
    private $thumbnail_blob;
    private $picture_ploc; // What is ploc? -> Picture Location
    private $thumbnail_ploc; // Same
    
    private $picture;
    private $thumbnail;
    
    private $galleryId;
    
    const GET_PICTURE_BLOB_BY_ID = "SELECT id, tag, title, picture_blob, thumbnail_blob FROM pic WHERE id = :id;";
    const GET_PICTURES_BLOB_BY_GALLERY_ID = "SELECT P.id, P.tag, P.title, P.picture_blob, P.thumbnail_blob FROM pic AS P INNER JOIN gallery_pic AS GP ON P.id = GP.pic_id INNER JOIN gallery AS G ON G.id = GP.gallery_id WHERE G.id = :idGallery;";
    const GET_X_PICTURES_BLOB = "SELECT id, tag, title, picture_blob, picture_thumbnail FROM pic ORDER BY id DESC LIMIT :num;";
    const GET_LAST_CREATED_PICTURE_ID_FOR_GALLERY_CONSTRAINT = "SELECT id from pic ORDER BY id DESC LIMIT 1";
    
    const ADD_PICTURE = "INSERT INTO pic (tag, title, picture_blob, thumbnail_blob) VALUES (:tag, :title, :picture_blob, :thumbnail_blob);";
    const ADD_GALLERY_CONSTRAINT = "INSERT INTO gallery_pic (gallery_id, pic_id) VALUES (:galleryId, :picId)";
    
    const UPDATE_TAG = "UPDATE gallery SET tag = :tag WHERE id = :id;";
    const UPDATE_TITLE = "UPDATE gallery SET title = :title WHERE id = :id;";
    
    const DELETE_GALLERY_BY_ID = "DELETE FROM gallery WHERE id = :id";
    
    public function __construct($galleryId = null, $id = null, $tag = null, $title = null) {
        $this->galleryId = $galleryId;
        $this->id = $id;
        $this->tag = $tag;
        $this->title = $title;
        $this->picture_blob = $this->picToBlob(PICTURENAME_IN_FILES_ARRAY);
    }
    
    public static function addPicture($galleryId, $tag, $title) {
        
        self::setQueryParameter(array('tag'=>$tag,'title'=>$title,'picture_blob'=>self::picToBlob(PICTURENAME_IN_FILES_ARRAY),'thumbnail_blob'=>self::createThumbnailBlob(PICTURENAME_IN_FILES_ARRAY)));
        self::modelInsert(self::ADD_PICTURE_STATEMENT);
        $newPicId = self::modelSelect(self::GET_LAST_CREATED_PICTURE_ID_FOR_GALLERY_CONSTRAINT_STATEMENT);
        self::setQueryParameter(array('galleryId' => $galleryId, 'picId' => $newPicId));
        self::modelInsert(self::ADD_GALLERY_CONSTRAINT_STATEMENT);
    }
    
    public static function updatePicture($id, $tag = null, $title = null) {
        
        if (isset($tag)) {
            self::setQueryParameter(array('id' => $id, 'tag' => $tag));
            self::modelUpdate(self::UPDATE_TAG_STATEMENT);
        }
        if (isset($title)) {
            self::setQueryParameter(array('id' => $id, 'title' => $title));
            self::modelUpdate(self::UPDATE_TITLE_STATEMENT);
        }
    }
    
    public static function getPictureById($id) {
        
        self::setQueryParameter(array('id' => $id));
        return self::modelSelect(self::GET_PICTURES_BLOB_BY_GALLERY_ID_STATEMENT);
    }
    
    public static function getPicturesFromGallery($idGallery) {
        
        self::setQueryParameter(array('idGallery' => $idGallery));
        return self::modelSelect(self::GET_PICTURES_BLOB_BY_GALLERY_ID_STATEMENT);
    }
    
    public static function getNumberOfPictures($number) {
        
        self::setQueryParameter(array('num' => $number));
        self::modelSelect(self::GET_X_PICTURES_BLOB_STATEMENT);
    }
    
    public static function picToBlob($nameInFilesArray) {
        
        $tmp = $_FILES[$nameInFilesArray]['tmp_name'];
        return file_get_contents($tmp);
    }
    
    public static function blobToPic($blob) {
        
        $puffer = base64_decode($blob);
        return imagecreatefromstring($puffer);
    }
    
    public static function createThumbnailBlob($nameInFilesArray) {
        
        //Source: http://www.php-einfach.de/experte/codeschnipsel/932-thumbnails/
        $tmp_thumb = NULL;
    
        list($width, $height) = getimagesize($_FILES[$nameInFilesArray]['tmp_name']);
        $imgratio=$width/$height;
    
        //Ist das Bild höher als breit?
        if($imgratio>1)
        {
            $newwidth = THUMBNAIL_SIZE;
            $newheight = THUMBNAIL_SIZE/$imgratio;
        }
        else
        {
            $newheight = THUMBNAIL_SIZE;
            $newwidth = THUMBNAIL_SIZE*$imgratio;
        }
    
        if(function_exists("imagecreatetruecolor")) {
    
            $thumb = imagecreatetruecolor($newwidth,$newheight);
        } else {
            $thumb = imagecreate ($newwidth,$newheight);
        }
        
        return file_get_contents($thumb);
    }
    
    const GET_PICTURES_BLOB_BY_ID_STATEMENT = 1;
    const GET_PICTURES_BLOB_BY_GALLERY_ID_STATEMENT = 2;
    const GET_X_PICTURES_BLOB_STATEMENT = 3;
    const GET_LAST_CREATED_PICTURE_ID_FOR_GALLERY_CONSTRAINT_STATEMENT = 4;
    
    private function modelSelect($whichSelectStatement) {
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
    
    private function modelInsert($whichInsertStatement) {
        switch ($whichInsertStatement) {
            case self::ADD_PICTURE_STATEMENT:
                self::$database->performQuery('Picture', self::ADD_PICTURE);
                
                return true;
            case self::ADD_GALLERY_CONSTRAINT_STATEMENT:
                self::$database->performQuery('Picture', self::ADD_GALLERY_CONSTRAINT);
    
                return true;
            default:
                return false;
        }
    }
    
    const UPDATE_TAG_STATEMENT = 1;
    const UPDATE_TITLE_STATEMENT = 2;
    
    private function modelUpdate($whichUpdateStatement) {
        switch($whichUpdateStatement) {
            case self::UPDATE_TAG_STATEMENT:
                self::$database->performQuery('Picture', self::UPDATE_TAG);
                return true;
            case self::UPDATE_TITLE_STATEMENT:
                self::$database->performQuery('Picture', self::UPDATE_TITLE);
                return true;
            default:
                return false;
        }
    }
    
    const DELETE_GALLERY_BY_ID_STATEMENT = 1;
    
    private function modelDelete($whichDeleteStatement) {
        switch ($whichDeleteStatement) {
            case self::DELETE_GALLERY_BY_ID_STATEMENT:
                self::$database->performQuery('Picture', self::DELETE_GALLERY_BY_ID);
                return true;
            default:
                return false;
        }
    }
    
    public function getId() {
        
        return htmlentities($this->id);
    }
    
    public function setId($id) {
        
        $this->id = $id;
    }
    
    public function getTag() {
        
        return htmlentities($this->tag);
    }
    
    public function setTag($tag) {
        
        $this->tag = $tag;
    }
    
    public function getTitle() {
        
        return htmlentities($this->title);
    }
    
    public function setTitle($title) {
        
        $this->title = $title;
    }
    
    public function getPictureBlob() {
        
        return htmlentities($this->picture_blob);
    }
    
    public function setPictureBlob($picture_blob) {
        
        $this->picture_blob = $picture_blob;
    }
    
    public function getThumbnailBlob() {
        
        return htmlentities($this->thumbnail_blob);
    }
    
    public function setThumbnailBlob($thumbnail_blob) {
        
        $this->thumbnail_blob = $thumbnail_blob;
    }
    
    public function getPicture() {
        
        return htmlentities($this->picture);
    }
    
    public function setPicture($picture) {
        
        $this->picture = $picture;
    }
    
    public function getThumbnail() {
        
        return htmlentities($this->thumbnail);
    }
    
    public function setThumbnail($thumbnail) {
        
        $this->thumbnail = $thumbnail;
    }
}