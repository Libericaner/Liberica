<?php
/**
 * User: Emaro
 * Date: 2017-03-10
 * Time: 13:55
 */


/**
 * @param string $title HTML title
 */
function printHead($title = 'PHP-MVC by DJM') {
    
    ?>
    
    <!DOCTYPE html>
    
    <meta charset="UTF-8"><title><?=$title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=CSS_PATH?>">
    
    <?php
}

function printMenu() {
    
    $whenUserIsSet = isset($_SESSION[USER]);
    ?>
    
    <nav>
        <ul>
            <?=menuItem('login', 'Login', !$whenUserIsSet)?>
            <?=menuItem('register', 'Registrieren', !$whenUserIsSet)?>
            <?=menuItem('hidden', 'Home', $whenUserIsSet)?>
            <?=menuItem('overview', 'Übersicht', $whenUserIsSet)?>
            <?=menuItem('logout'.($whenUserIsSet?'&t='.$_SESSION[TOKEN]:''), 'Logout', $whenUserIsSet)?>
        </ul>
        <hr>
    </nav>
    <?php
}

function printFoot() {
    
    ?>
    
    <br>
    <footer>
        <p>&#169; 2017 - David Schor, Joel Häberli, Miro Albrecht
    </footer>
    
    <?php
}

function menuItem($ref, $label, $condition = TRUE) {
    
    return $condition ? '<li>' . viewLink($ref, $label) . "\n" : "";
}

function viewLink($view, $label) {
    
    return a("./?view=${view}", $label);
}

function a($target, $label) {
    
    return '<a href="' . $target . '">' . htmlentities($label) . '</a>';
}

function printIfSet($var) {
    
    if ($var)
        return $var;
    
    return "";
}