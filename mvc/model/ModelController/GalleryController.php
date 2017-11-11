<?php
/**
 * User: joel-haeberli
 * Date: 11.11.17
 * Time: 12:56
 */

class GalleryController extends Controller
{
    public static function addGallery($userId, $name, $description) {

        self::executeQuery(GalleryQueries::ADD_NEW_GALLERY,['galleryName' => $name, 'galleryDescription' => $description]);
        // DANGER: this could cause an error, if two galleries get created at once
        $newGalleryId = self::executeQuery(GalleryQueries::GET_LAST_INSERTED_GALLERY_FOR_CONSTRAINT_STATEMENT);
        self::executeQuery(GalleryQueries::ADD_USER_CONSTRAINT, ['uid' => $userId, 'gid' => $newGalleryId]);
    }

    public static function getGalleryById($id) : Gallery {

        self::setQueryParameter(array('idGallery' => $id));
        return self::modelSelect(self::GET_GALLERY_BY_ID_STATEMENT);
    }

    public static function getGalleriesByUserEmail($email) {

        self::setQueryParameter(array('email' => $email));
        return self::modelSelect(self::GET_GALLERY_BY_USER_EMAIL_STATEMENT);
    }

    public static function getGalleriesByUserId($id) {

        self::setQueryParameter(array('id' => $id));
        return self::modelSelect(self::GET_GALLERY_BY_USER_ID_STATEMENT);
    }

    public static function getGalleries($numberOfGalleries) {

        self::setQueryParameter(array('num' => $numberOfGalleries));
        return self::modelSelect(self::GET_X_GALLERIES_STATEMENT);
    }

    public static function deleteGalleryById($id) {

        self::setQueryParameter(array('id' => $id));
        return self::modelDelete(self::DELETE_GALLERY_BY_ID_STATEMENT);
    }

    public function updateName($name)
    {
        if (is_nan($this->getId()) || empty($name))
            return FALSE;

        self::setQueryParameter(['galleryName' => $name, 'id' => $this->getId()]);
        self::modelUpdate(self::UPDATE_NAME_STATEMENT);

        return TRUE;
    }

    public function updateDescription($desc)
    {
        if (is_nan($this->getId()))
            return FALSE;

        self::setQueryParameter(['galleryDescription' => $desc, 'id' => $this->getId()]);
        self::modelUpdate(self::UPDATE_DESCRIPTION_STATEMENT);

        return TRUE;
    }
}