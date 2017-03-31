<?php
/**
 * User: Emaro
 * Date: 2017-03-31
 * Time: 13:47
 */

if (isset($_SESSION['u']))
{
    header('Location: ./?view=hidden');
    exit;
}
?>

<h1>Registrieren</h1>

<?=printIfSet($arg)?>

<form action="./?view=register" method="post">
    <input type="text" name="user" placeholder="Username">
    <input type="password" name="password" placeholder="Passwort">
    <input type="submit" name="sub[register]">
</form>
