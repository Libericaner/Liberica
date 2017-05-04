<?php
/**
 * User: Joel Häberli
 * Date: 10.03.2017
 * Time: 10:04
 */
include_once "mvc/Database/Database.php";

require_once "mvc/Model/User.php";
require_once "mvc/Model/Gallery.php";
require_once "mvc/Model/Picture.php";
require_once "mvc/Model/Tag.php";

//TODO : Parameter anpassen
$database = new Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
Model::setDatabase($database);