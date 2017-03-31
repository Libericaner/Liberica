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