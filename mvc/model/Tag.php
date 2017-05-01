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
    
    const INSERT_TAG = "INSERT INTO tag (tag_name) VALUES (:name)";
    
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
                $arr = array();
                foreach ($result as $item)
                {
                    $arr[] = new Tag($item['tag_id'], $item['tag_name']);
                }
                return $arr;
        }
    }
    
    const INSERT_TAG_STATEMENT = 1;
    
    private function modelInsert($whichInsertStatement) {
        
        switch ($whichInsertStatement)
        {
            case self::INSERT_TAG_STATEMENT:
                return self::$database->performQuery('Tag', self::INSERT_TAG);
        }
    }
    
    private function modelUpdate(Integer $whichUpdateStatement) {
        // TODO: Implement modelUpdate() method.
    }
    
    private function modelDelete(Integer $whichDeleteStatement) {
        // TODO: Implement modelDelete() method.
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->label;
    }
}