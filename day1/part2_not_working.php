<?php
// This one does not work for case 'eightwothree'

const DIGITS = [
    'one' => 1,
    'two' => 2,
    'three' => 3,
    'four' => 4,
    'five' => 5,
    'six' => 6,
    'seven' => 7,
    'eight' => 8,
    'nine' => 9,
];

$answer = 0;
foreach (getLines() as $line) {
    toDigit($line);

    preg_match('/(\d).*(\d)/', $line, $matches);

    if (count($matches) == 3) {
        $digits = (int) $matches[1] . $matches[2];
    } else {
        preg_match('/(\d)/', $line, $matches);
        $digits = (int) !empty($matches) ? $matches[0] . $matches[1] : 0 ;
    }

    $answer += $digits;
}

function toDigit(&$line) {
    foreach (array_keys(DIGITS) as $digit) {
        $pattern = "/$digit/";
        $replace = DIGITS[$digit];
        $line = preg_replace($pattern, $replace, $line);
    }
}

function getLines() {
    $filename = 'datafile.txt';
    $file = file(getcwd() . DIRECTORY_SEPARATOR. $filename);
    return $file;
}

echo "Answer: $answer " . PHP_EOL;


