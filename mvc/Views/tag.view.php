<?php
/**
 * User: Emaro
 * Date: 2017-05-01
 * Time: 17:21
 */

var_dump(Tag::getTagByName($_POST['tag']));

if (isset($_POST['tag']))
{
    Tag::create($_POST['tag']);
    header("Location: ");
}

foreach (Tag::getAll() as $tag)
{
    print "<p>" . $tag->getId() . " - " . $tag->getName();
}


?>

<form action="" method="post">
    <input type="text" name="tag" placeholder="Neuer Tag">
    <input type="submit" name="sub[createTag]" value="Erstelle Tag">
</form>
