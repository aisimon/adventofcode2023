<?php

const DIGITS = [
    'one' => '1', 'two' => '2', 'three' => '3', 'four' => '4', 'five' => '5',
    'six' => '6', 'seven' => '7', 'eight' => '8', 'nine' => '9' ];

$lines = file(getcwd() . DIRECTORY_SEPARATOR. 'datafile.txt');

$answer = 0;
for ($i = 0; $i < count($lines); $i++) {
    $line = rtrim($lines[$i]);
    list ($len, $line_value) = [ strlen($line), 0];
    
    // Go from left
    list ($a, $b, $found1) = [0, 1, false];
    while (($a+$b) < $len) {
        if ($found1 = parser($a, $b, 'left', $line)) {
            break;
        }
        $b++;
    }

    // Go from right
    list ($a, $b, $found2) = [$len-1, 1, false];
    while (($a+$b) <= $len) {
        if ($found2 = parser($a, $b, 'right', $line)) {
            break;
        }
        $a--;
        $b++;
    }

    $line_value = ($found1 == $found2) ? $found1 : $found1 . $found2;
    $answer += $line_value;
    echo "Line " . ($i + 1) ." : $line | Line Value: $line_value | Answer: $answer" . PHP_EOL;
}

function parser(int $a, int $b, $direction, string &$line) {
    $check = substr($line, $a, $b);
    
    if ($direction == 'left') {
        if (is_numeric(substr($check, -1))) { // check last char for numeric value
            return substr($check, -1);
        } 
    } else {
        if (is_numeric(substr($check, 0, 1))) { // check last char for numeric value
            return substr($check, 0, 1);
        } 
    }
    if (strlen($check) < 3) { // cannot possible match a English number words
        return false;
    }
    foreach (array_keys(DIGITS) as $digit) {
        if (strpos($check, $digit) !== false) {
            return DIGITS[$digit];
        }
    }
    return false;
}

echo "Answer: $answer " . PHP_EOL; // 53407, 44799
echo "Memory Usage: " . memory_get_peak_usage() . " bytes" . PHP_EOL;
echo "Processed Lines: $i" . PHP_EOL;