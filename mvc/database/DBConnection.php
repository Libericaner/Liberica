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

//TODO : Parameter anpassen
$database = new Database("localhost", "root", "gibbiX12345", "m151");
Model::setDatabase($database);