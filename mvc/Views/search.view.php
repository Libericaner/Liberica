<?php
/**
 * User: Joel Häberli
 * Date: 06.05.2017
 * Time: 13:13
 */
?>
<h1>Bildsuche</h1>

<h2>Gebe einen Begriff ein und wir werden dir das Resultat liefern</h2>

<form action="" method="post">
    <input type="text" name="search" placeholder="Suchbegriff">
    <input type="submit" name="sub[search]" value="suchen">
</form>

<?php

if (isset($_POST['search'])) {
    $pics = Xsearch();
    foreach ($pics as $pic) {
        ?>
        <div>
            <p> <?php
                //imagepng(imagecreatefromstring($pic->getThumbnailBlob()));
                echo ("<img src='data:image/png;base64," . base64_encode($pic->getThumbnailBlob()). "' />");
                echo ("<p>Titel: " . $pic->getTitle() . " / Tags: " . $pic->getTag() . "</p>");
                echo ("<a href='./?view=picture&id=" . $pic->getId() . "'>Original-Bild</a>");
                ?>
            </p>
        </div>
        <?php
    }
}

