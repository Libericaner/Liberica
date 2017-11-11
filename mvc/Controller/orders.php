<?php
/**
 * UserController: Emaro
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
    
    if (!UserController::verifyUser($_SESSION[USER], $_POST['password']))
        return 'Ungültiges Passwort';
    
    if (UserController::getUserByEmail($_POST['email']))
        return "Die E-Mail-Adresse " . htmlentities($_POST['email']) . " wird bereits von einem anderen Benutzer verwendet";
    
    $currentUser = UserController::getUserByEmail($_SESSION[USER]);
    
    $currentUser->updateUser($currentUser->getIdUser(), $_POST['email']);
    
    if ($currentUser->getIdUser() !== UserController::getUserByEmail($_POST['email'])->getIdUser())
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
    
    if (!UserController::verifyUser($_SESSION[USER], $_POST['oldPassword']))
        return 'Das aktuelle Passwort ist ungültig';
    
    $currentUser = UserController::getUserByEmail($_SESSION[USER]);
    
    // Attention: updateUser needs a hashed password
    $currentUser->updateUser($currentUser->getIdUser(), NULL, password_hash($_POST['newPassword'], PASSWORD_DEFAULT));
    
    if (!UserController::verifyUser($_SESSION[USER], $_POST['newPassword']))
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
    
    if (UserController::getUserByEmail($_POST['user']))
        return "Die E-Mail-Adresse " . htmlentities($_POST['user']) . " wird bereits von einem anderen Benutzer verwendet";
    
    $isValid = passwordIsValid($_POST['password']);
    
    if ($isValid !== TRUE)
        return $isValid;
    
    UserController::addUser($_POST['user'], $_POST['password']); // Raw pw expected
    
    if (!UserController::verifyUser($_POST['user'], $_POST['password']))
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
    
    if (!UserController::verifyUser($_SESSION[USER], $_POST['password']))
        return 'Das eingegebene Passwort ist ungültig';
    
    $currentUser = UserController::getUserByEmail($_SESSION[USER]);
    
    UserController::deleteUser($currentUser->getIdUser());
    session_destroy();
    headerLocationView('register');
    exit;
}

// GALLERY

/*function XcreateGallery()
{
    redirectGuest();
    
    if (empty($_POST['name']))
        return 'Gibb mindestens einen Namen für die Galerie ein';
    
    $currentUser = UserController::getUserByEmail($_SESSION[USER]);
    
    GalleryController::addGallery($currentUser->getIdUser(), $_POST['name'], $_POST['description']);
    
    headerLocationView('galleries');
    exit;
}*/

function XchangeGallery()
{
    redirectGuest();
    
    if (empty($_POST['id']))
        return 'Ein Fehler ist aufgetreten';
    
    if (empty($_POST['name']))
        return 'Der Name darf nicht leer sein';
    
    $gallery = GalleryController::getGalleryById($_POST['id']);
    $galleries = GalleryController::getGalleriesByUserEmail($_SESSION[USER]);
    
    if (!in_array($gallery, $galleries))
        return 'Ein Fehler ist aufgetreten';
    
    $gallery->updateName($_POST['name']);
    $gallery->updateDescription($_POST['description']);
    
    return NULL;
}