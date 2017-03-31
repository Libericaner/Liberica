<?php
/**
 * User: Emaro
 * Date: 2017-03-31
 * Time: 10:23
 *
 * Each method need the prefix X (for Xecurity). Without it can't be called from a form
 */

function XsaveTextToFile() {
    
    fileAppend($_POST['data']);
    return 'saved in file: ' . $_POST['data'];
}

function XregisterUser() {
    
    return 'User "' . $_POST['name'] . '" registered';
}

function XtoHome() {
    
    header('Location: ./?view=home');
    exit;
}

function Xlogin()
{
    if (isset($_POST['username'], $_POST['password']) && !empty($_POST['username']))
    {
        if ($_POST['username'] === 'foo' && $_POST['password'] === 'bar')
        {
            $_SESSION['u'] = $_POST['username'];
            header('Location: ./?view=hidden');
            exit;
        }
        return 'Falsch';
    }
    else
    {
        return 'Gibb etwas ein';
    }
}