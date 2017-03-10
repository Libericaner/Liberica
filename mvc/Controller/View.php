<?php

/**
 * User: Emaro
 * Date: 2017-03-10
 * Time: 11:19
 */
class View {
    const SUFFIX = '.view.php';
    const LOCATION = 'mvc/Views/';
    const PATTERN = self::LOCATION . '*' . self::SUFFIX;
    const ERROR = '404';
}