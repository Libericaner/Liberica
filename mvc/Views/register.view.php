<?php
/**
 * User: Emaro
 * Date: 2017-03-31
 * Time: 13:47
 */

if (isset($_SESSION[USER]))
{
    header('Location: ./?view=hidden');
    exit;
}
?>

<h1>Registrieren</h1>

<p class="error"><?=printIfSet($arg)?>

<form action="./?view=register" method="post">
    <input type="text" name="user" placeholder="Username" value="<?=isset($_POST['user'])?$_POST['user']:''?>">
    <input type="password" name="password" placeholder="Passwort">
    <input type="submit" name="sub[register]">
</form>
