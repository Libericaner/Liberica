<?php
/**
 * User: Emaro
 * Date: 2017-05-06
 * Time: 18:38
 */
?>

<h1>Galerien</h1>

<h2>Neue Galerie erstellen</h2>

<form action="" method="post">
    <p>
        <input type="text" name="name" placeholder="Name der Galerie" value="<?=isset($_POST['name'])?$_POST['name']:''?>">
        <input type="text" name="description" placeholder="Beschreibung">
        <input type="submit" name="sub[createGallery]" value="Galerie erstellen">
    </p>
</form>


<h2>Deine Galerien</h2>

<?php printGalleriesBy($_SESSION[USER]) ?>