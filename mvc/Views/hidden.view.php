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

<p><?=$_SESSION[TOKEN]?></p>
<p><?=$_SESSION['t2']?></p>

<?php

echo bin2hex(random_bytes(32));