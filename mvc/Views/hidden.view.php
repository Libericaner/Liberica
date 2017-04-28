<?php
/**
 * User: Emaro
 * Date: 2017-03-31
 * Time: 11:19
 */

if (!isset($_SESSION[USER]))
{
    header('Location: ./?view=home');
    exit;
}

?>

<h1>Hidden</h1>

<p>Du bist eingeloggt. Username: <?=$_SESSION[USER]?></p>
