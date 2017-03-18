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
    
    <!-- HTML meta informations -->
    <head>
        <meta charset="UTF-8">
        <title><?=$title?></title>
        <link rel="stylesheet" href="css/main.css">
    </head>

    <!-- HTML body -->
    <body><code>body:</code>
    <?php
}

function printMenu() {
    
    ?>
    
    <!-- Menu -->
    <nav><code>menu:</code>
        <ul>
            <li><?=viewLink('demo', 'Demo')?></li>
            <?=li(viewLink('404', 'Error Page'))?>
        </ul>
    </nav>
    
    <!--------------------------------------------->
    <?php
}

function printFoot() {
    
    ?>

    
    <!--------------------------------------------->
    
    <!-- Footer -->
    <footer><code>footer:</code>
        <p>&#169; 2017 - David Schor, Joel Häberli, Miro Albrecht</p>
    </footer>

    </body>
    <?php
}

function li($html) {
    
    return '<li>' . $html . "</li>\n";
}

function viewLink($view, $label) {
    
    return a("./?view=${view}", $label);
}

function a($target, $label) {
    
    return '<a href="' . $target . '">' . htmlentities($label) . '</a>';
}