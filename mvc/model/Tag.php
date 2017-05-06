<?php

/**
 * User: Joel Häberli
 * Date: 17.03.2017
 * Time: 08:43
 */
class Tag extends Model {
    
    private $id;
    private $label;
    
    const GET_TAG_BY_ID = "SELECT tag_id, tag_name FROM tag WHERE tag_id = :id";
    const GET_TAG_BY_NAME = "SELECT tag_id, tag_name FROM tag WHERE tag_name = :name";
    const GET_ALL = "SELECT * FROM tag";
    const GET_TAG_EXISTS = "SELECT * FROM tag WHERE tag_name = :tag_name;";
    const GET_PICTURES_BY_TAG = "SELECT P.id, P.tag, P.title, P.picture_blob, P.thumbnail_blob FROM tag AS T INNER JOIN tag_pic AS TP ON T.tag_id = TP.tag_id INNER JOIN pic AS P ON P.id = TP.pic_id WHERE T.tag_id = :tid;";
    
    const INSERT_TAG = "INSERT INTO tag (tag_name) VALUES (:name)";
    const ADD_TAG_TO_PICTURE = "INSERT INTO tag_pic (tag_id, pic_id) VALUES (:tid, :pid)";
    
    const REMOVE_CONSTRAINT_WITH_PIC = "DELETE FROM tag_pic WHERE tag_id = :tid AND pic_id = :pid";
    
    public function __construct($id, $name) {
        $this->id = $id;
        $this->label = $name;
    }
    
    public static function create($name)
    {
        if (empty($name))
            return false;
        
        if (!is_null(self::getTagByName($name)))
            return false;
        
        self::setQueryParameter(['name' => $name]);
        self::modelInsert(self::INSERT_TAG_STATEMENT);
        
        return self::getTagByName($name);
    }
    
    public static function searchPictures($tagName) {
        
        if (self::tagExists($tagName)) {
    
            $t = self::getTagByName($tagName);
            self::setQueryParameter(['tid' => $t->getId()]);
            return self::modelSelect(self::GET_PICTURES_BY_TAG_STATEMENT);
        } else {
            return NULL;
        }
    }
    
    public static function tagExists($name) {
        
        self::setQueryParameter(['tag_name' => $name]);
        return self::modelSelect(self::GET_TAG_EXISTS_STATEMENT);
    }
    
    public static function setPictureTagConstraint($tagId, $picId) {
        
        self::setQueryParameter(['tid' => $tagId, 'pid' => $picId]);
        self::modelInsert(self::ADD_TAG_TO_PICTURE_STATEMENT);
    }
    
    public static function removePictureTagConstraint($tagId, $picId) {
        
        self::setQueryParameter(['tid' => $tagId, 'pid' => $picId]);
        self::modelDelete(self::REMOVE_CONSTRAINT_WITH_PIC_STATEMENT);
    }
    
    public static function getTagByName($name)
    {
        self::setQueryParameter(['name' => $name]);
        return self::modelSelect(self::GET_TAG_BY_NAME_STATEMENT);
    }
    
    public static function getTagById($id)
    {
        self::setQueryParameter(['id' => $id]);
        return self::modelSelect(self::GET_TAG_BY_ID_STATEMENT);
    }
    
    public static function getAll()
    {
        return self::modelSelect(self::GET_ALL_STATEMENT);
    }
    
    const GET_TAG_BY_ID_STATEMENT = 1;
    const GET_TAG_BY_NAME_STATEMENT = 2;
    const GET_ALL_STATEMENT = 3;
    const GET_TAG_EXISTS_STATEMENT = 4;
    const GET_PICTURES_BY_TAG_STATEMENT = 5;
    
    private function modelSelect($whichSelectStatement) {
        
        switch ($whichSelectStatement)
        {
            case self::GET_TAG_BY_ID_STATEMENT:
                $result = self::$database->performQuery('Tag', self::GET_TAG_BY_ID);
                return count($result) == 0 ? null : new Tag($result[0]['tag_id'], $result[0]['tag_name']);
            case self::GET_TAG_BY_NAME_STATEMENT:
                $result = self::$database->performQuery('Tag', self::GET_TAG_BY_NAME);
                return ($result && $result[0]) ? new Tag($result[0]['tag_id'], $result[0]['tag_name']) : null;
            case self::GET_ALL_STATEMENT:
                $result = self::$database->performQuery('Tag', self::GET_ALL);
                return self::tagsToArray($result);
            case self::GET_TAG_EXISTS_STATEMENT:
                $result = self::$database->performQuery('Tag', self::GET_TAG_EXISTS);
                return !empty($result);
            case self::GET_PICTURES_BY_TAG_STATEMENT:
                $result = self::$database->performQuery('Tag', self::GET_PICTURES_BY_TAG);
                return Picture::resultToPicturesArray($result);
            default: return null;
        }
    }
    
    public static function tagsToArray($result) {
        
        $ts = array();
        foreach ($result as $tag) {
            
            $t = new Tag($tag['tag_id'], $tag['tag_name']);
            $ts[] = $t;
        }
        
        return $ts;
    }
    
    const INSERT_TAG_STATEMENT = 1;
    const ADD_TAG_TO_PICTURE_STATEMENT = 2;
    
    private function modelInsert($whichInsertStatement) {
        
        switch ($whichInsertStatement)
        {
            case self::INSERT_TAG_STATEMENT:
                return self::$database->performQuery('Tag', self::INSERT_TAG);
            case self::ADD_TAG_TO_PICTURE_STATEMENT:
                return self::$database->performQuery('Tag', self::ADD_TAG_TO_PICTURE);
        }
    }
    
    private function modelUpdate($whichUpdateStatement) {
        // TODO: Implement modelUpdate() method.
    }
    
    const REMOVE_CONSTRAINT_WITH_PIC_STATEMENT = 1;
    
    private function modelDelete($whichDeleteStatement) {
    
        switch ($whichDeleteStatement)
        {
            case self::REMOVE_CONSTRAINT_WITH_PIC_STATEMENT:
                return self::$database->performQuery('Tag', self::REMOVE_CONSTRAINT_WITH_PIC);
        }
    }
    
    public function getId()
    {
        return htmlentities($this->id);
    }
    
    public function getName()
    {
        return htmlentities($this->label);
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function setName($name)
    {
        $this->label = $name;
    }
}