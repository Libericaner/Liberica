<?php
/**
 * User: Emaro
 * Date: 03.03.2017
 * Time: 10:47
 */

require_once "mvc/Controller/Controller.php";

$view = '';

if (isset($_GET['view'])) {

    $view = $_GET['view'];
}

new Controller($view);
