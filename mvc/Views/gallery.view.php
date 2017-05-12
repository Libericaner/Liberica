<?php
/**
 * User: Emaro
 * Date: 2017-05-07
 * Time: 10:45
 */

if (empty($_GET['id']) || is_nan($_GET['id']))
    headerLocationView('galleries');

$gallery = Gallery::getGalleryById($_GET['id']);

if ($gallery == NULL)
    headerLocationView('galleries');

?>

<h1><?=$gallery->getName()?><br><small><?=$gallery->getDescription()?></small></h1>

<h2>Bearbeiten</h2>

<form action="" method="post">
    <p>
        <input type="text" name="name" placeholder="Name" value="<?=$gallery->getName()?>">
        <input type="text" name="description" placeholder="Beschreibung" value="<?=$gallery->getDescription()?>">
        <input type="hidden" name="id" value="<?=$gallery->getId()?>">
        <input type="submit" name="sub[changeGallery]" value="Änderungen speichern">
    </p>
    <p>
        <input type="password" name="pw" placeholder="Passwort">
        <input type="hidden" name="gid" value="<?=$gallery->getId()?>">
        <input class="error" type="submit" name="sub[deleteGallery]" value="Galerie löschen">
        <em>Kann nicht rückgängig gemacht werden!</em>
    </p>
</form>

<h2>Bild hochladen</h2>
<form action="" method="post" enctype="multipart/form-data">
    <p>
        <input type="text" name="title" placeholder="Picture Name">
        <input type="text" name="tags" placeholder="Tags (;)">
        <input type="file" name="picture" >
        <input type="hidden" name="galleryid" value="<?=$gallery->getId()?>">
        <input type="submit" name="sub[uploadImage]" value="Bild hinzufügen">
    </p>
</form>

<h2>Bilder</h2>

<form action="" method="post">
    <input type="text" name="filter" value="<?=isset($_POST['filter'])?$_POST['filter']:''?>" placeholder="Filter">
    <input type="submit" value="Nur Bilder mit diesem Tag anzeigen">
    <?=isset($_POST['filter'])?"<a href='./?view=gallery&id=".$gallery->getId()."'>Filter löschen</a>":''?>
    
</form>
<br>
<?php printPicturesFrom($gallery, $_POST['filter'] ?? '') ?>

<?php printPicture('gallery&id=' . $gallery->getId()) ?>
