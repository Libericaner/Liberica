<?php
/**
 * User: Emaro
 * Date: 2017-03-10
 * Time: 10:55
 */

// Name of a view: alwas ends with '.view.php';
// Location: mvc/Views

?>

    <h1>Demo View</h1>
    
    <p>Simple HTML output</p>
    
    <!-- Links always begin with './?view=' and ends with the name of the target view without the '.view.php' suffix -->
    <p>Demo Link: <a href="./?view=demo">Demo</a><br>
        Demo Link: <a href="./?view=xyz">Invalid Link</a></p>

