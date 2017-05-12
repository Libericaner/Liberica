<?php
/**
 * User: Emaro
 * Date: 2017-05-06
 * Time: 18:25
 */
?>

<h1>Profil</h1>

<p>Deine Aktuelle E-Mail-Adresse: <strong><?=printEmail()?></strong></p>

<br>

<form action="" method="post">
    <h3>E-Mail-Adresse ändern</h3>
    <p class="error"><?=isset($_POST['sub']['changeEmail'])?printIfSet($arg):''?></p>
    <p>
        <input type="text" name="email" placeholder="Neue E-Mail-Adresse" value="<?=isset($_POST['email'])?$_POST['email']:''?>">
        <input type="password" name="password" placeholder="Passwort">
        <input type="submit" name="sub[changeEmail]" value="E-Mail-Adresse ändern">
    </p>
</form>

<br>

<form action="" method="post">
    <h3>Passwort ändern</h3>
    <p class="error"><?=isset($_POST['sub']['changePassword'])?printIfSet($arg):''?></p>
    <p>
        <input type="password" name="oldPassword" placeholder="Aktuelles Passwort">
        <input type="password" name="newPassword" placeholder="Neues Passwort">
        <input type="password" name="newPasswordRepeat" placeholder="Passwort wiederholen">
        <input type="submit" name="sub[changePassword]" value="Passwort ändern">
    </p>
    <p><em>Achtung: Im Moment können vergessene Passwörter nicht zurückgesetzt werden!</em></p>
</form>

<br>

<form action="" method="post">
    <h3 class="error">Account löschen</h3>
    <p class="error"><?=isset($_POST['sub']['changePassword'])?printIfSet($arg):''?></p>
    <p>
        <input type="password" name="password" placeholder="Passwort">
        <input type="submit" name="sub[deleteUser]" value="Account für immer löschen">
    </p>
</form>