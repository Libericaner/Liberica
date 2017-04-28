<?php
/**
 * User: Emaro
 * Date: 2017-03-31
 * Time: 13:40
 */

if ($_SESSION[TOKEN] == $_GET['t'])
{
    session_destroy();
    header('Location: ./?view=login');
    exit;
}


header('Location: ./?view=login');
exit;