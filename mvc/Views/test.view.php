<?php
/**
 * User: Joel Häberli
 * Date: 01.05.2017
 * Time: 17:23
 */

// Gallery::addGallery(2,"TEST2","Dies ist die 2. Test-Gallerie");

$galleries = Gallery::getGalleriesByUserId(2);

foreach ($galleries as $gallery) {
    echo join("<br>", [$gallery->getId(), $gallery->getName(), $gallery->getDescription()]);
    echo "<br><br>";
}
