<?php
/**
 * User: Emaro
 * Date: 2017-05-04
 * Time: 19:51
 */
?>
<h1>Übersicht</h1>

<p>Du bist eingeloggt als: <?=$_SESSION[USER]?></p>

<h2>Gallerien</h2>

<h3>Deine Gallerien</h3>
<table>
    <tr>
        <th>Name</th>
        <th>Beschriebung</th>
    </tr>
    <?php
    foreach (Gallery::getGalleriesByUserEmail($_SESSION[USER]) as $gallery)
    {
        echo "<tr><td>", join("</td>\n<td>", ["<a href='?view=overview&gallery=".$gallery->getId()."'>".$gallery->getName()."</a>", $gallery->getDescription()]), "</td></tr>\n";
    }
    ?>
</table>

<h3>Gallerie erstellen</h3>
<form action="" method="post">
    <p><input type="text" name="name" placeholder="Name der Gallerie">
    <p><input type="text" name="description" placeholder="Beschreibung">
    <p><input type="submit" name="sub[createGallery]" value="Gallerie erstellen"></p>
</form>

<?php

if (isset($_GET['gallery']))
{
    if ($gallery = Gallery::getGalleryById(intval($_GET['gallery'])))
    {
        echo "<h3>";
        echo "Bearbeite Gallerie «", $gallery->getName(), '»';
        echo "</h3>";
    }
}
?>

