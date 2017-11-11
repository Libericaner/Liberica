<?php
/**
 * User: joel-haeberli
 * Date: 11.11.17
 * Time: 14:19
 */

class PictureQueries
{
    const GET_PICTURE_BLOB_BY_ID = "SELECT id, tag, title, picture_blob, thumbnail_blob FROM pic WHERE id = :id;";
    const GET_PICTURES_BLOB_BY_GALLERY_ID = "SELECT P.id, P.tag, P.title, P.picture_blob, P.thumbnail_blob FROM pic AS P INNER JOIN gallery_pic AS GP ON P.id = GP.pic_id INNER JOIN gallery AS G ON G.id = GP.gallery_id WHERE G.id = :idGallery;";
    const GET_X_PICTURES_BLOB = "SELECT id, tag, title, picture_blob, picture_thumbnail FROM pic ORDER BY id DESC LIMIT :num;";
    const GET_LAST_CREATED_PICTURE_ID_FOR_GALLERY_CONSTRAINT = "SELECT id from pic ORDER BY id DESC LIMIT 1";
    const GET_TAGS_OF_PICTURE = "SELECT T.tag_name, T.tag_id FROM pic AS P INNER JOIN tag_pic AS TP ON P.id = TP.pic_id INNER JOIN tag AS T ON T.tag_id = TP.tag_id WHERE P.id = :pid;";

    const ADD_PICTURE = "INSERT INTO pic (tag, title, picture_blob, thumbnail_blob) VALUES (:tag, :title, :picture_blob, :thumbnail_blob);";
    const ADD_GALLERY_CONSTRAINT = "INSERT INTO gallery_pic (gallery_id, pic_id) VALUES (:galleryId, :picId)";

    const UPDATE_TAG = "UPDATE gallery SET tag = :tag WHERE id = :id;";
    const UPDATE_TITLE = "UPDATE gallery SET title = :title WHERE id = :id;";

    const DELETE_GALLERY_BY_ID = "DELETE FROM gallery WHERE id = :id";

    const DELETE_PICTURE_FROM_GALLERY = "DELETE FROM gallery_pic WHERE pic_id = :picture";
    const DELETE_PICTURE = "DELETE FROM pic WHERE id = :picture";
}