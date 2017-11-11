<?php
/**
 * User: joel-haeberli
 * Date: 11.11.17
 * Time: 14:02
 */

class GalleryQueries
{
    const GET_GALLERY_BY_ID = "SELECT id, name, description FROM gallery WHERE id = :idGallery";
    const GET_GALLERY_BY_USER_EMAIL = "SELECT G.name, G.description, G.id, U.email FROM gallery AS G INNER JOIN user_gallery AS UG on G.id = UG.gallery_id INNER JOIN user AS U ON UG.user_id = U.id WHERE U.email = :email;";
    const GET_GALLERY_BY_USER_ID = "SELECT G.name, G.description, G.id, U.email FROM gallery AS G JOIN user_gallery AS UG on G.id = UG.gallery_id INNER JOIN user AS U ON UG.user_id = U.id WHERE U.id = :id;";
    const GET_X_GALLERIES        = "SELECT G.id, G.name, G.description FROM gallery ORDER BY G.id DESC LIMIT :num;";
    const GET_LAST_INSERTED_GALLERY_FOR_CONSTRAINT = "SELECT id FROM gallery ORDER BY id DESC LIMIT 1";

    const ADD_NEW_GALLERY = "INSERT INTO gallery (name, description) VALUES (:galleryName, :galleryDescription)";
    const ADD_USER_CONSTRAINT = "INSERT INTO user_gallery (user_id, gallery_id) VALUES (:uid, :gid)";

    const UPDATE_GALLERY_NAME = "UPDATE gallery SET name = :galleryName WHERE id = :id";
    const UPDATE_GALLERY_DESCRIPTION = "UPDATE gallery SET description = :galleryDescription WHERE id = :id";

    const DELETE_GALLERY_NAME    = "DELETE FROM gallery WHERE id = :id";

    const QUERY_FAIL = "We could not find this query";
}