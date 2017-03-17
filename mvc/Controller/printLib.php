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

    <head>
        <meta charset="UTF-8">
        <title><?=$title?></title>

        <link rel="stylesheet" href="css/main.css">
    </head>

    <body><code>body:</code>
    <?php
}

function printMenu() {
    
    ?>

    <nav><code>menu:</code>
        <ul>
            <li><?=viewLink('demo', 'Demo')?></li>
                <?=li(viewLink('404', 'Error Page'))?>
                <?=li(viewLink('cc', 'Controll Center'))?>
        </ul>
    </nav>
    <?php
}

function printFoot() {
    
    ?>
    <br>
    <footer><code>footer:</code>
        <p>&#169; 2017 - David Schor, Joel Häberli, Miro Albrecht</p>
    </footer>

    </body>
    <?php
}

function li($html) {
    
    return '<li>' . $html . '</li>';
}

function viewLink($view, $label) {
    
    return a("./?view=${view}", $label);
}

function a($target, $label) {
    
    return '<a href="' . $target . '">' . htmlentities($label) . '</a>';
}