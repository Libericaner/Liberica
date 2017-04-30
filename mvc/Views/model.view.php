<?php
/**
 * User: Emaro
 * Date: 2017-04-30
 * Time: 19:37
 */

$g = new Gallery();

print "Meine Gallerien:<br>\n";
var_dump($g->getGalleriesByUserEmail($_SESSION[USER]));

?>
<hr>
<form action="?view=model" method="post">
    <p>Name:
        <input type="text" name="name">
    <p>Beschreibung:
        <input type="text" name="description">
    <p><input type="submit" name="sub[createGallery]" value="Erstellen"></p>
</form>
