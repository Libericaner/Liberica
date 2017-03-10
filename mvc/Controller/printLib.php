<?php
/**
 * User: Emaro
 * Date: 2017-03-10
 * Time: 13:55
 */

function printHead($title = 'PHP-MVC by DJM') {
    
    ?>
    
    <!DOCTYPE html>
    
    <head>
        <meta charset="UTF-8">
        <title><?=$title?></title>
    </head>
    
    <body><code>body:</code>
    <?php
}

function printFoot() {
    
    ?>
    
    <footer><code>footer:</code>
        &#169; 2017 - David Schor, Joel Häberli, Miro Albrecht
    </footer>
    
    </body>
    <?php
}