<?php
/**
 * User: Emaro
 * Date: 2017-05-06
 * Time: 19:33
 */

function XchangeEmail()
{
    redirectGuest();
    
    if (someoneEmpty($_POST['email'], $_POST['password']))
        return 'Gibb überall etwas ein';
    
    if (isInvalidEmail($_POST['email']))
        return 'Gibb eine gültige E-Mail-Adresse ein';
    
    if (!User::verifyUser($_SESSION[USER], $_POST['password']))
        return 'Ungültiges Passwort';
    
    if (User::getUserByEmail($_POST['email']))
        return "Die E-Mail-Adresse " . htmlentities($_POST['email']) . " wird bereits von einem anderen Benutzer verwendet";
    
    $currentUser = User::getUserByEmail($_SESSION[USER]);
    
    $currentUser->updateUser($currentUser->getIdUser(), $_POST['email']);
    
    if ($currentUser->getIdUser() !== User::getUserByEmail($_POST['email'])->getIdUser())
        return 'Ein Fehler ist aufgetreten';
    
    $_SESSION[USER] = $_POST['email'];
    
    header("Location: ./?view=user");
    exit;
}

function XchangePassword()
{
    redirectGuest();
    
    if (someoneEmpty($_POST['oldPassword'], $_POST['newPassword'], $_POST['newPasswordRepeat']))
        return 'Gibb überall etwas ein';
    
    if ($_POST['newPassword'] !== $_POST['newPasswordRepeat'])
        return 'Passwörter stimmen nicht überein';
    
    $isValid = passwordIsValid($_POST['newPassword']);
    
    if ($isValid !== TRUE)
        return $isValid;
    
    if (!User::verifyUser($_SESSION[USER], $_POST['oldPassword']))
        return 'Das aktuelle Passwort ist ungültig';
    
    $currentUser = User::getUserByEmail($_SESSION[USER]);
    
    $currentUser->updateUser($currentUser->getIdUser(), NULL, password_hash($_POST['newPassword'], PASSWORD_DEFAULT));
    
    if (!User::verifyUser($_SESSION[USER], $_POST['newPassword']))
        return 'Ein Fehler ist aufgetreten';
    
    header("Location: ./?view=user");
    exit;
}