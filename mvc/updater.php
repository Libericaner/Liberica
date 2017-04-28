<?php

exit;

$path = '';
$user = '';
$repo = '';
$src = "https://github.com/$user/$repo/zipball/master";
$dest = './';

exec(sprintf("rm -rf %s", escapeshellarg($path)));

$temp = rand();
$tempZip = "{$temp}.zip";

file_put_contents($tempZip, file_get_contents($repo));

$zip = new ZipArchive;
$zip->open($tempZip);
$zip->extractTo($dest);
$zip->close();

rename(glob("./$user-$repo*")[0], $path);

exec(sprintf("rm -rf %s", escapeshellarg($tempZip)));