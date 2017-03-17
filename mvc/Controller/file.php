<?php
/**
 * User: Emaro
 * Date: 2017-03-17
 * Time: 10:24
 */

function printFile() {
    
    $f = file('file.txt');
    
    if ($f == NULL)
        return;
    
    foreach ($f as $line) {
        echo $line . '<br>';
    }
}

function fileAppend($content) {
    
    $f = file('file.txt');
    
    $c = count($f) -1 ;
    $l = $f[$c ];
    
    echo $c . $l . $content;
    
    if ($f[count($f) - 1] != $content . "\n")
        file_put_contents('file.txt', $content . "\n", FILE_APPEND);
}