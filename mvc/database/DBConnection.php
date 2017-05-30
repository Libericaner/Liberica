<?php
/**
 * User: Joel Häberli
 * Date: 10.03.2017
 * Time: 10:04
 */

//TODO : Parameter anpassen
$database = new Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
Model::setDatabase($database);