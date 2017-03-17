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
            <li><a href="./?view=demo">Demo</a></li>
            <li><a href="./?view=404">Error page</a></li>
        </ul>
    </nav>
    <?php
}

function printFoot() {
    
    ?>

    <footer><code>footer:</code>
        <p>&#169; 2017 - David Schor, Joel Häberli, Miro Albrecht</p>
    </footer>

    </body>
    <?php
}