<?php
/**
 * User: joel-haeberli
 * Date: 11.11.17
 * Time: 14:20
 */

class TagQueries
{
    const GET_TAG_BY_ID = "SELECT tag_id, tag_name FROM tag WHERE tag_id = :id";
    const GET_TAG_BY_NAME = "SELECT tag_id, tag_name FROM tag WHERE tag_name = :name";
    const GET_ALL = "SELECT * FROM tag";
    const GET_TAG_EXISTS = "SELECT * FROM tag WHERE tag_name = :tag_name;";
    const GET_PICTURES_BY_TAG = "SELECT P.id, P.tag, P.title, P.picture_blob, P.thumbnail_blob FROM tag AS T
        INNER JOIN tag_pic AS TP ON T.tag_id = TP.tag_id
        INNER JOIN pic AS P ON P.id = TP.pic_id
        JOIN gallery_pic AS gp ON P.id = gp.pic_id
        JOIN user_gallery AS ug ON gp.gallery_id = ug.gallery_id
        JOIN user AS u ON ug.user_id = u.id
        WHERE T.tag_id = :tid AND u.email = :email;";
    const GET_PICTURES_BY_TAG_AND_GALLERY = "SELECT P.id, P.tag, P.title, P.picture_blob, P.thumbnail_blob FROM tag AS T
        INNER JOIN tag_pic AS TP ON T.tag_id = TP.tag_id
        INNER JOIN pic AS P ON P.id = TP.pic_id
        JOIN gallery_pic AS gp ON P.id = gp.pic_id
        WHERE T.tag_id = :tid AND gp.gallery_id = :gid;";

    const INSERT_TAG = "INSERT INTO tag (tag_name) VALUES (:name)";
    const ADD_TAG_TO_PICTURE = "INSERT INTO tag_pic (tag_id, pic_id) VALUES (:tid, :pid)";

    const REMOVE_CONSTRAINT_WITH_PIC = "DELETE FROM tag_pic WHERE tag_id = :tid AND pic_id = :pid";
}