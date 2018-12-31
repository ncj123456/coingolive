<?php

$cacheDir = __DIR__ . '/../cache/*';
$files = glob($cacheDir); // get all file names
foreach ($files as $file) { // iterate files
    if (is_file($file))
        unlink($file); // delete file
}