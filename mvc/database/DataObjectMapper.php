<?php
/**
 * User: joel-haeberli
 * Date: 11.11.17
 * Time: 15:30
 */

/**
 * Class DataObjectMapper maps query results to DataObjects
 */
class DataObjectMapper
{

    //Result Properties
    private static $tagProps = ['tag_id','tag_name'];
    private static $userProps = ['user_id','user_email','user_password'];
    private static $galleryProps = ['gallery_id','gallery_description','gallery_name'];
    private static $pictureProps = ['pic_id','pic_picture_blob','pic_tag','pic_thumbnail_blob','pic_title'];

    public static function resultToDataObject($dataObjectType, $result) {
        $r = array();
        array_push($r, $result);
        switch ($dataObjectType) {
            case "User":
                return self::getUser($r);
            case "Tag":
                return self::getTag($r);
            case "Gallery":
                return self::getGallery($r);
            case "Picture":
                return self::getPicture($r);
            default:
                return "Qonverter has failed :( (Unknown DataObjectType)";
        }
    }

    private static function getUser($result) {
        $users = [];
        foreach ($result as $user) {
            $u = new User();
            foreach (self::$userProps as $prop) {
                if (self::propertyExists($prop,$user)) {
                    switch($prop) {
                        case 'user_id':
                            $u->setId($user['user_id']);
                            break;
                        case 'user_email':
                            $u->setEmail($user['user_email']);
                            break;
                        case 'user_password':
                            $u->setPassword($user['user_password']);
                            break;
                        default:
                            break;
                    }
                }
            }
            array_push($users, $u);
        }
        return $users;
    }

    private static function getTag($result) {
        $tags = [];
        foreach ($result as $tag) {
            $t = new Tag();
            foreach (self::$tagProps as $prop) {
                if (self::propertyExists($prop,$tag)) {
                    switch($prop) {
                        case 'tag_id':
                            $t->setId($tag['tag_id']);
                            break;
                        case 'tag_name':
                            $t->setName($tag['tag_name']);
                            break;
                        default:
                            break;
                    }
                }
            }
            array_push($tags, $t);
        }
        return $tags;
    }

    private static function getGallery($result) {
        $galleries =[];
        foreach ($result as $gallery) {
            $g = new Gallery();
            foreach (self::$galleryProps as $prop) {
                if (self::propertyExists($prop,$gallery)) {
                    switch($prop) {
                        case 'gallery_id':
                            $g->setId($gallery['gallery_id']);
                            break;
                        case 'gallery_description':
                            $g->setDescription($gallery['gallery_description']);
                            break;
                        case 'gallery_name':
                            $g->setName($gallery['gallery_name']);
                            break;
                        default:
                            break;
                    }
                }
            }
            array_push($galleries, $g);
        }
        return $galleries;
    }

    private static function getPicture($result) {
        $pictures =[];
        foreach ($result as $picture) {
            $p = new Picture();
            foreach (self::$pictureProps as $prop) {
                if (self::propertyExists($prop,$picture)) {
                    switch($prop) {
                        case 'pic_id':
                            $p->setId($picture['pic_id']);
                            break;
                        case 'pic_picture_blob':
                            $p->setPictureBlob($picture['pic_picture_blob']);
                            break;
                        case 'pic_tag':
                            $p->setTag($picture['pic_tag']);
                            break;
                        case 'pic_thumbnail_blob':
                            $p->setThumbnailBlob($picture['pic_thumbnail_blob']);
                            break;
                        case 'pic_title':
                            $p->setTitle($picture['pic_title']);
                            break;
                        default:
                            break;
                    }
                }
            }
            array_push($pictures, $p);
        }
        return $pictures;
    }

    private static function propertyExists($resultPropertyName, $result) {
        return array_key_exists($resultPropertyName, $result);
    }
}