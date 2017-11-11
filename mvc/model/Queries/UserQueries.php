<?php
/**
 * User: joel-haeberli
 * Date: 11.11.17
 * Time: 14:39
 */

class UserQueries
{
    const GET_USER_BY_NAME = "SELECT id, email FROM user WHERE email = :email LIMIT 1;";
    const GET_USER_BY_ID   = "SELECT email FROM user WHERE id = :id;";
    const ADD_USER         = "INSERT INTO user (email, password) VALUES (:email, :password);";

    const GET_PASSWORD_HASH = "SELECT password FROM user WHERE email = :email LIMIT 1;";

    const UPDATE_USERNAME = "UPDATE user SET email = :email WHERE id = :id;";
    const UPDATE_PASSWORD = "UPDATE user SET password = :password WHERE id = :id;";

    const DELETE_USER_BY_ID = "DELETE FROM user WHERE id = :id;";

    //FAILS
    const VERIFICATION_FAIL = "username or password is invalid";
    const QUERY_FAIL        = "We could not find this query";
    const UPDATE_FAIL       = "We could not execute the update, cause of invalid values";
}