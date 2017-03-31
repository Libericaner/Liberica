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
    
    <link rel="stylesheet" href="css/main.css">
    
    <?php
}

function printMenu() {
    
    ?>
    
    <nav>
        <ul>
            <?=menuItem('demo', 'Demo')?>
            <?=menuItem('404', 'Error Page')?>
            <?=menuItem('cc', 'Controll Center')?>
        </ul>
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

function menuItem($ref, $label) {
    
    return '<li>' . viewLink($ref, $label) . "\n";
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
    
    return "NULL";
}