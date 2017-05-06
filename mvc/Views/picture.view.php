<?php
/**
 * User: Emaro
 * Date: 2017-05-05
 * Time: 13:34
 */


if (is_null($_SESSION[USER]) || empty($_SESSION[USER]))
    return "No USER";

if (!isset($_GET['id']))
    return "No ID";

if (is_nan($_GET['id']))
    return "ID is NAN";

header('Content-Type: image/png');

$p = Picture::getPictureById($_GET['id']);
$b = $p->getPictureBlob();

ob_end_clean();

imagepng(imagecreatefromstring($b));

exit;