<?php
/**
 * User: Emaro
 * Date: 2017-05-04
 * Time: 19:51
 */
?>
<h1>Übersicht</h1>

<p>Du bist eingeloggt als: <?=$_SESSION[USER]?></p>

<hr>
<h2>Galerien</h2>

<h3>Deine Galerien</h3>
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
    <p><input type="text" name="name" placeholder="Name der Galerie">
    <p><input type="text" name="description" placeholder="Beschreibung">
    <p><input type="submit" name="sub[createGallery]" value="Galerie erstellen"></p>
</form>

<?php

if (isset($_GET['gallery']))
{
    if ($gallery = Gallery::getGalleryById(intval($_GET['gallery'])))
    {
        echo "<h3>";
        echo "Bearbeite Galerie «", $gallery->getName(), '»';
        echo "</h3>";
        
        ?>
        <form action="" method="post">
            <p><input type="text" name="name" value="<?=$gallery->getName()?>">
                <input type="text" name="description" placeholder="Beschreibung" value="<?=$gallery->getDescription()?>">
                <input type="submit" value="Änderungen speichern"></p>
            <p><input type="password" name="pw" placeholder="Passwort">
                <input type="hidden" name="gid" value="<?=$gallery->getId()?>">
                <input type="submit" name="sub[deleteGallery]" value="Galerie löschen"></p>
            
        </form>
        <?php
    }
}
?>
<hr>
<?php
if (isset($_GET['gallery']))
{
    if ($gallery = Gallery::getGalleryById(intval($_GET['gallery'])))
    {
        $galleryName = $gallery->getName();
        echo "<h2>Bilder von $galleryName</h2>";
        
        echo "<p>[Hier Uploadformular einfügen]</p>";
        
        foreach (Picture::getPicturesFromGallery($gallery->getId()) as $picture)
        {
            echo random_int(0, 1) ? $picture->getPicture() : $picture->getThumbnail();
        }
    }
    else
    {
        echo "<h2>Bilder</h2>";
        echo "<p>Es ist keine Galerie ausgewählt</p>";
    }
}
else
{
    echo "<h2>Bilder</h2>";
    echo "<p>Es ist keine Galerie ausgewählt</p>";
}
?>