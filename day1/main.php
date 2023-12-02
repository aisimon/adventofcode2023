<?php

define('DS', DIRECTORY_SEPARATOR);

$filename = getcwd() . DS. 'datafile.txt';
echo $filename;

$file = file($filename);

foreach ($file as $line) {
    echo $line;
}