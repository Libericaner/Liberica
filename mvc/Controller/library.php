<?php
/**
 * User: Emaro
 * Date: 2017-05-06
 * Time: 20:16
 *
 * A collection of useful functions
 * TODO: Separate framework functions from application functions
 */

function passwordIsValid($password)
{
    if (strlen($password) < 8)
        return 'Das Passwort muss mindestens 8 Zeichen lang sein';
    
    if (!preg_match('/[a-z]/', $password))
        return 'Das Passwort muss mindestens einen Kleinbuchstaben enthalten';
    
    if (!preg_match('/[A-Z]/', $password))
        return 'Das Passwort muss mindestens einen Grossbuchstaben enthalten';
    
    if (!preg_match('/[0-9]/', $password))
        return 'Das Passwort muss mindestens eine Zahl enthalten';
    
    if (!preg_match('/[\W_]/', $password))
        return 'Das Passwort muss mindestens ein Sonderzeichen enthalten';
    
    if (!preg_match('/[a-z]/', $password))
        return 'Das Passwort muss mindestens einen Kleinbuchstaben enthalten';
    
    return TRUE;
}

function redirectGuest()
{
    if (empty($_SESSION[USER]) || !User::getUserByEmail($_SESSION[USER]))
        headerLocationView('login');
}

function redirectUser()
{
    if (isset($_SESSION[USER]) && User::getUserByEmail($_SESSION[USER]))
        headerLocationView('home');
}

function someoneEmpty ()
{
    $args = func_get_args();
    
    foreach ($args as $var)
    {
        if (empty($var))
            return TRUE;
    }
    
    return FALSE;
}

function isInvalidEmail($email)
{
    return !filter_var($email, FILTER_VALIDATE_EMAIL);
}

function headerLocationView($view)
{
    header("Location: ./?view=$view");
    exit;
}