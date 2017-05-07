<?php
/**
 * User: Joel Häberli
 * Date: 06.05.2017
 * Time: 13:13
 */

$search = isset($_REQUEST['search']) ? htmlentities($_REQUEST['search']) : NULL;
if (isset($_GET['search']))
    $arg = Xsearch();

?>
<h1>Bildsuche</h1>

<p>Hier kannst du all deine Bilder nach Tags durchsuchen</p>

<form action="" method="post">
    <input type="text" name="search" placeholder="Suchbegriff" value="<?=$search?:''?>">
    <input type="submit" name="sub[search]" value="suchen">
</form>

<br>

<?php

printSearchResult($search, $arg);

printPicture('search'. ($search? '&search='.$search : ''));