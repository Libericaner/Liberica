<?php
/**
 * User: Emaro
 * Date: 2017-04-30
 * Time: 19:37
 */

$g = new Gallery();

print "<h3 style='padding-left: 10px'>Meine Gallerien:</h3><p>";

$all = $g->getGalleriesByUserEmail($_SESSION[USER]);
print "<table><tr><th>Titel</th><th>Beschreibung</th><th>Löschen</th></tr>";
foreach ($all as $item)
{
    print "<tr><td>".$item->getName()."</td><td>".$item->getDescription() . "</td><td><a href='./?view=model&cmd=delete&id=".$item->getId()."'>❌</a></td></tr>";
}

print "</table>";

?>
<hr>
<form action="?view=model" method="post">
    <p>Name:
        <input type="text" name="name">
    <p>Beschreibung:
        <input type="text" name="description">
    <p><input type="submit" name="sub[createGallery]" value="Gallerie erstellen"></p>
</form>
