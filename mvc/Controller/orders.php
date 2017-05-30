<?php
/**
 * User: Emaro
 * Date: 2017-05-06
 * Time: 19:33
 *
 * Callable actions collection two
 * Each method need the prefix X (for Xecurity). Without it can't be called from a form
 */

// USER

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
    
    headerLocationView('user');
    exit; // Not necessary
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
    
    // Attention: updateUser needs a hashed password
    $currentUser->updateUser($currentUser->getIdUser(), NULL, password_hash($_POST['newPassword'], PASSWORD_DEFAULT));
    
    if (!User::verifyUser($_SESSION[USER], $_POST['newPassword']))
        return 'Ein Fehler ist aufgetreten';
    
    headerLocationView('user');
    exit; // Not necessary
}

function Xregister()
{
    redirectUser();
    
    if (someoneEmpty($_POST['user'], $_POST['password']))
        return 'Gibb überall etwas ein';
    
    if (isInvalidEmail($_POST['user']))
        return 'Gibb eine gültige E-Mail-Adresse ein';
    
    if (User::getUserByEmail($_POST['user']))
        return "Die E-Mail-Adresse " . htmlentities($_POST['user']) . " wird bereits von einem anderen Benutzer verwendet";
    
    $isValid = passwordIsValid($_POST['password']);
    
    if ($isValid !== TRUE)
        return $isValid;
    
    User::addUser($_POST['user'], $_POST['password']); // Raw pw expected
    
    if (!User::verifyUser($_POST['user'], $_POST['password']))
        return 'Ein Fehler ist aufgetreten';
    
    $_SESSION[USER] = $_POST['user'];
    $_SESSION[TOKEN] = bin2hex(random_bytes(TOKEN_LEN));
    
    headerLocationView('home');
    exit;
}

function XdeleteUser()
{
    redirectGuest();
    
    if (empty($_POST['password']))
        return 'Du musst dein Passwort eingeben, um deinen Account zu löschen';
    
    if (!User::verifyUser($_SESSION[USER], $_POST['password']))
        return 'Das eingegebene Passwort ist ungültig';
    
    $currentUser = User::getUserByEmail($_SESSION[USER]);
    
    User::deleteUser($currentUser->getIdUser());
    session_destroy();
    headerLocationView('register');
    exit;
}

// GALLERY

function XcreateGallery()
{
    redirectGuest();
    
    if (empty($_POST['name']))
        return 'Gibb mindestens einen Namen für die Galerie ein';
    
    $currentUser = User::getUserByEmail($_SESSION[USER]);
    
    Gallery::addGallery($currentUser->getIdUser(), $_POST['name'], $_POST['description']);
    
    headerLocationView('galleries');
    exit;
}

function XchangeGallery()
{
    redirectGuest();
    
    if (empty($_POST['id']))
        return 'Ein Fehler ist aufgetreten';
    
    if (empty($_POST['name']))
        return 'Der Name darf nicht leer sein';
    
    $gallery = Gallery::getGalleryById($_POST['id']);
    $galleries = Gallery::getGalleriesByUserEmail($_SESSION[USER]);
    
    if (!in_array($gallery, $galleries))
        return 'Ein Fehler ist aufgetreten';
    
    $gallery->updateName($_POST['name']);
    $gallery->updateDescription($_POST['description']);
    
    return NULL;
}