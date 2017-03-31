<?php
/**
 * User: Emaro
 * Date: 2017-03-31
 * Time: 11:14
 */

if (isset($_SESSION['u']))
{
    header('Location: ./?view=hidden');
    exit;
}

?>

<h1>Login</h1>

<p><?=printIfSet($arg)?>

<form action="./?view=login" method="post">
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Passwort">
    <input type="submit" name="sub[login]" value="Anmelden">
</form>