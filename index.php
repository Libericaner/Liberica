<?php
/**
 * User: Emaro
 * Date: 03.03.2017
 * Time: 10:47
 */

require_once "mvc/config.php";
require_once "mvc/Controller/Controller.php";

$view = DEFAULT_PAGE;

if (isset($_GET['view']))
    $view = $_GET['view'];

new Controller($view);
