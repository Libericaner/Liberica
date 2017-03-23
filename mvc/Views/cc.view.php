<?php
/**
 * User: Emaro
 * Date: 2017-03-17
 * Time: 10:10
 */
?>

<h1>Controller</h1><p><?=printIfSet($arg)?></p>
<form action="./?view=cc" method="post">
    <input name="name" placeholder="Name" type="text">
    <br>
    <input name="pw" placeholder="Password" type="password">
    <br>
    <input name="pw-repeat" placeholder="Password" type="password">
    <br>
    <input name="sub[register]" type="submit">
</form><br>

<form action="./?view=cc" method="post">
    <input name="data" type="text">
    <input name="command" type="hidden" value="save-string">
    <input type="submit" name="sub[file]" value="Save String!">
</form><br>

<form action="./?view=cc" method="post">
    <input type="submit" name="sub[redir]" value="Submit and redirect">
</form>

<br>
<div>
    <p><strong>file.txt</strong> stores the follwing content:</p>
    <?=printFile()?>
</div>
