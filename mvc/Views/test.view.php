<?php
/**
 * User: Joel Häberli
 * Date: 01.05.2017
 * Time: 17:23
 */

echo Gallery::addGallery(1,"TEST2","Dies ist die 2. Test-Gallerie");

$galleries = Gallery::getGalleriesByUserId(1);

foreach ($galleries as $gallery) {
    echo var_dump($gallery);
}
