<?php
define('DS', DIRECTORY_SEPARATOR);

$filename = 'datafile.txt';
$file = file(getcwd() . DS. $filename);

$total = 0;
foreach ($file as $line) {
    preg_match('/(\d).*(\d)/', $line, $matches);
    if (count($matches) == 3) {
        $digits = (int) $matches[1] . $matches[2];
    } else {
        preg_match('/(\d)/', $line, $matches);
        $digits = (int) !empty($matches) ? $matches[0] . $matches[1] : 0 ;
    }

    $total += $digits;
}

echo "Total: $total " . PHP_EOL;