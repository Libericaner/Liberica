<?php
/**
 * User: Emaro
 * Date: 2017-03-31
 * Time: 10:23
 *
 * Each method need the prefix X (for Xecurity). Without it can't be called from a form
 */


function XtoHome() {
    
    header('Location: ./?view=home');
    exit;
}

function Xlogin() {
    
    if (isset($_POST['username'], $_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])) {
        if (User::verifyUser($_POST['username'], $_POST['password'])) {
            $_SESSION['u'] = $_POST['username'];
            header("Location: ./?view=hidden");
            exit;
        }
        return 'Falsche Anmeldedaten';
    }
    else {
        return 'Gibb überall etwas ein';
    }
}

function Xregister() {
    if (isset($_POST['user'], $_POST['password']) && !empty($_POST['user']) && !empty($_POST['password']))
    {
        if (User::addUser($_POST['user'], $_POST['password']))
        {
            if (User::verifyUser($_POST['user'], $_POST['password'])) {
                $_SESSION['u'] = $_POST['user'];
                header("Location: ./?view=hidden");
                exit;
            }
            return 'Es ist ein Fehler aufgetreten';
        }
        return 'User konnte nicht registriert werden';
    }
    return 'Fülle alle Felder aus';
}