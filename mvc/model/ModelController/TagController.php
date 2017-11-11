<?php
/**
 * User: joel-haeberli
 * Date: 11.11.17
 * Time: 12:56
 */

require_once("Controller.php");
require_once("../DTO/Tag.php");
require_once("../Queries/TagQueries.php");

class TagController extends Controller
{
    public static function create($name)
    {
        if (empty($name))
            return false;

        if (!is_null(self::getTagByName($name)))
            return false;

        self::execute(self::INSERT_TAG_STATEMENT,['name' => $name]);

        return self::getTagByName($name);
    }

    public static function searchPicturesByUser($tagName, $email) {

        if (self::tagExists($tagName)) {

            $t = self::getTagByName($tagName);
            self::setQueryParameter(['tid' => $t->getId(), 'email' => $email]);
            return self::modelSelect(self::GET_PICTURES_BY_TAG_STATEMENT);
        } else {
            return NULL;
        }
    }

    public static function searchPicturesByGallery($tagName, Gallery $gallery) {

        if (self::tagExists($tagName)) {

            $t = self::getTagByName($tagName);
            self::setQueryParameter(['tid' => $t->getId(), 'gid' => $gallery->getId()]);
            return self::modelSelect(self::GET_PICTURES_BY_TAG_AND_GALLERY_STATEMENT);
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
}