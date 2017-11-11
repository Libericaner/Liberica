<?php
/**
 * User: joel-haeberli
 * Date: 11.11.17
 * Time: 12:56
 */

class PictureController extends Controller
{

    const RESULT_TYPE = 'Picture';

    public function addPicture($galleryId, $tag, $title) {

        //Bild hinzufügen
        $this->executor->executeQuery(PictureQueries::ADD_PICTURE,self::RESULT_TYPE,['tag'=>$tag,'title'=>$title,'picture_blob'=>self::picToBlob(PICTURENAME_IN_FILES_ARRAY),'thumbnail_blob'=>self::createThumbnailBlob(PICTURENAME_IN_FILES_ARRAY)]);

        //Bild verbinden mit Galerie
        $newPicId = self::modelSelect(self::GET_LAST_CREATED_PICTURE_ID_FOR_GALLERY_CONSTRAINT_STATEMENT);
        self::setQueryParameter(array('galleryId' => $galleryId, 'picId' => $newPicId));
        self::modelInsert(self::ADD_GALLERY_CONSTRAINT_STATEMENT);

        //Tags mit Bild verbinden
        $tagArray = explode(";", $tag);
        foreach ($tagArray as $tag) {
            $tag = trim($tag);
            if (Tag::tagExists($tag)) {
                $t = Tag::getTagByName($tag);
                Tag::setPictureTagConstraint($t->getId(), $newPicId);
            } else {
                $t = Tag::create($tag);
                Tag::setPictureTagConstraint($t->getId(), $newPicId);
            }
        }
    }

    public function addTag($tagName) {

        if (Tag::tagExists($tagName)) {
            $t = Tag::getTagByName($tagName);
            Tag::setPictureTagConstraint($t->getId(), $this->getId());
        } else {
            $t = Tag::create($tagName);
            Tag::setPictureTagConstraint($t->getId(), $this->getId());
        }
    }

    public function removeTag($tagName) {
        if(in_array($tagName,$this->getTags())) {
            $t = Tag::getTagByName($tagName);
            Tag::removePictureTagConstraint($t->getId(), $this->getId());
            unset($this->tags[array_search($tagName, $this->tags)]);
        } else {
            return NULL;
        }
    }

    public function hasUserAccess($email)
    {
        if (!$this->getId())
            return NULL;
        self::setQueryParameter(['pid' => $this->getId()]);
        $owner = self::modelSelect(self::HAS_USER_ACCESS_STATEMENT);
        if ($owner)
            return $owner == $email;
        return false;
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

    public function getGallery() : Gallery
    {
        if (!$this->getId())
            return NULL;

        self::setQueryParameter(['pid' => $this->getId()]);
        return self::modelSelect(self::GET_GALLERY_STATEMENT);
    }

    public static function getPictureById($id) : Picture{

        self::setQueryParameter(array('id' => $id));
        $res = self::modelSelect(self::GET_PICTURES_BLOB_BY_ID_STATEMENT);
        return $res;

    }

    public static function getPicturesFromGallery($idGallery) {

        self::setQueryParameter(array('idGallery' => $idGallery));
        return self::modelSelect(self::GET_PICTURES_BLOB_BY_GALLERY_ID_STATEMENT);
    }

    public static function getNumberOfPictures($number) {

        self::setQueryParameter(array('num' => $number));
        self::modelSelect(self::GET_X_PICTURES_BLOB_STATEMENT);
    }

    public static function deletePictureById($id) {

        self::setQueryParameter(array('picture' => $id));
        self::modelDelete(self::DELETE_PICTURE_FROM_GALLERY_STATEMENT);
        self::modelDelete(self::DELETE_PICTURE_STATEMENT);
    }

    public static function picToBlob($nameInFilesArray) {

        $tmp = $_FILES[$nameInFilesArray]['tmp_name'];
        return file_get_contents($tmp);
    }

    public static function blobToPic($blob) {
        return '<img src="data:image/jpg;base64,' .  base64_encode($blob)  . '" />';
    }

    public static function createThumbnailBlob($nameInFilesArray) {

        $image = imagecreatefromstring(self::picToBlob($nameInFilesArray));

        $tempName = bin2hex(random_bytes(8)) . '.pic';

        imagepng($image, $tempName);

        list($width, $height) = getimagesize($tempName);

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

        $thumb = imagecreatetruecolor ($newwidth,$newheight);

        imagecopyresized($thumb, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        unlink($tempName);

        ob_end_clean();
        ob_start();
        imagepng($thumb);
        $contents = ob_get_contents();
        ob_end_clean();
        ob_start();
        imagedestroy($image);

        return $contents;
    }
}