<?php
/**
 * User: Joel Häberli
 * Date: 10.03.2017
 * Time: 10:04
 */
include_once "Database.php";

//TODO : Parameter anpassen
$database = new Database("host", "username", "password", "database");
$db = $database->getDatabaseConnection();