<?php
/**
 * User: Emaro
 * Date: 2017-03-10
 * Time: 13:55
 */


/**
 * @param string $title HTML title
 */
function printHead($title = 'PHP-MVC by DJM') {
    
?>
<!DOCTYPE html>

<meta charset="UTF-8" xmlns="http://www.w3.org/1999/html"><title><?=$title?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="<?=CSS_PATH?>">

<?php
}

function printMenu() {
    
$whenUserIsSet = isset($_SESSION[USER]);
?>

<nav>
  <ul>
<?=menuItem('login', 'Login', !$whenUserIsSet)?>
<?=menuItem('register', 'Registrieren', !$whenUserIsSet)?>
<?=menuItem('home', 'Home', $whenUserIsSet)?>
<?=menuItem('galleries', 'Galerien', $whenUserIsSet)?>
<?=menuItem('search', 'Suche', $whenUserIsSet)?>
<?=menuItem('user', 'Profil', $whenUserIsSet)?>
<?=menuItem('logout'.($whenUserIsSet?'&t='.$_SESSION[TOKEN]:''), 'Logout', $whenUserIsSet)?>
  </ul>
  <hr>
</nav>
<?php
}

function printFoot() {

if (!PRINT_FOOTER) return;
?>


<footer>
    <p>&#169; 2017 - David Schor, Joel Häberli, Miro Albrecht
</footer>

<?php
}

function menuItem($ref, $label, $condition = TRUE) {
    
    return $condition ? '    <li>' . viewLink($ref, $label) . "\n" : "";
}

function viewLink($view, $label) {
    
    return a("./?view=${view}", $label);
}

function a($target, $label) {
    
    return '<a href="' . $target . '">' . htmlentities($label) . '</a>';
}

function printIfSet($var) {
    
    if ($var)
        return $var;
    
    return "";
}

function printEmail()
{
    return $_SESSION[USER];
}

function printGalleriesBy($user)
{
?>
<table>
    <tr>
        <th>Name</th>
        <th>Beschriebung</th>
    </tr>
    <?php
    foreach (Gallery::getGalleriesByUserEmail($user) as $gallery)
    {
        echo "<tr><td>", join("</td>\n<td>", ["<a href='?view=gallery&id=".$gallery->getId()."'>".$gallery->getName()."</a>", $gallery->getDescription()]), "</td></tr>\n";
    } ?>
</table>
<?php
}

function printPicturesFrom(Gallery $gallery, $filter)
{
    echo "<div id='imgcont'>";
    
    if ($filter)
    {
        $pics = Tag::searchPicturesByGallery($filter, $gallery);
        if (!$pics)
            $pics = Picture::getPicturesFromGallery($gallery->getId());
    }
    else
        $pics = Picture::getPicturesFromGallery($gallery->getId());
    
    foreach ($pics as $picture)
    {
        $galleryId = $gallery->getId();
        $pictureId = $picture->getId();
        
        echo "<div class='sqr'><a href='./?view=gallery&id=${galleryId}&picture=${pictureId}'>";
        echo "<img src='./?view=picture&id=$pictureId&thumb' />";
        
        echo "</a>";
        echo "</div>";
    }
    echo "<span class='clr'></span></div>";
}

function printPicture($source)
{
    if (empty($_GET['picture']) || is_nan($_GET['picture']))
        return;
    
    $picture = Picture::getPictureById($_GET['picture']);
    
    if ($picture == NULL)
        return;
    
    $pictureId = $picture->getId();
    $pictureName = $picture->getTitle();
    $tagString = join(", ", array_map( function ($x) { return $x->getName(); } ,$picture->getTags()));
    
    ?>
    <div class="full">
        <img src="./?view=picture&id=<?=$picture->getId()?>" alt="">
    </div>
    <div class="cmd">
        
        <?php
        echo "<p id='tags'><strong>$pictureName</strong>";
        if (!empty($tagString))
            
            echo "<br>Tags: $tagString";
        ?>
        </p>
        <div class="formalike">
            <button onclick="location.href = './?view=<?=$source?>'">Zurück</button>
            <?php
            if (isset($_GET['showgallery']))
                echo "<button onclick=\"location.href = './?view=gallery&id=".$picture->getGallery()->getId()."'\">Zur Galerie</button>";
            ?>
        </div>
        
        <form action="" method="post">
            <input type="text" name="tagName" placeholder="Tag">
            <input type="hidden" name="pid" value="<?=$pictureId?>">
            <input type="submit" value="Hinzufügen" name="sub[addTagToPic]">
            <input type="submit" value="Entfernen" name="sub[removeTagFromPic]">
        </form>
        <form action="" method="post">
            <input type="hidden" name="pictureId" value="<?=$pictureId?>">
            <input class="error" type="submit" name="sub[deletePicture]" value="Bild Löschen">
        </form>
    
    </div>
    <?php
}

function printSearchResult($search, $arg)
{
    if (isset($search) && is_array($arg)) {
        
        echo "<div id='imgcont'>";
        
        
        foreach ($arg as $picture)
        {
            $galleryId = $picture->getGallery()->getId();
            $pictureId = $picture->getId();
            
            echo "<div class='sqr'><a href='./?view=search". ($search ? '&search='.$search. '&showgallery' : '') ."&picture=${pictureId}'>";
            echo "<img src='./?view=picture&id=$pictureId&thumb' />";
            
            echo "</a>";
            echo "</div>";
        }
        echo "<span class='clr'></span></div>";
    }
    else
    {
        print "<p>".htmlentities($arg)."</p>";
    }
}