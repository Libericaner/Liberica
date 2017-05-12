<?php
/**
 * User: Emaro
 * Date: 2017-05-05
 * Time: 13:34
 */

ob_clean();

if (is_null($_SESSION[USER]) || empty($_SESSION[USER]))
    return "No USER";

if (!isset($_GET['id']))
    return "No ID";

if (is_nan($_GET['id']))
    return "ID is NAN";


$p = Picture::getPictureById($_GET['id']);

if (!$p->hasUserAccess($_SESSION[USER]))
    return NULL;


$b = NULL;


if ($_GET['thumb'] == 1)
{
    $b = $p->getNewThumb();
}
else
    $b = $p->getPictureBlob();

header('Content-Type: image/png');


$img = imagecreatefromstring($b);

if ($img === FALSE)
    $img = imagecreatefromstring($p->getPictureBlob());

ob_end_clean();

if (imagepng($img))
    exit;

if (imagejpeg($img))
    exit;

if (imagegif($img))
    exit;

if (imagewbmp($img))
    exit;