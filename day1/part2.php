<?php
const DIGITS = [
    'one' => 1, 'two' => 2, 'three' => 3, 'four' => 4, 'five' => 5,
    'six' => 6, 'seven' => 7, 'eight' => 8, 'nine' => 9 ];

$lines = file(getcwd() . DIRECTORY_SEPARATOR. 'datafile.txt');

$answer = 0;
for ($i=0; $i<count($lines); $i++) {
    $line = rtrim($lines[$i]);
    list ($a, $b, $value, $cont, $len) = [0, 1, 0, true, strlen($line)];

    while ($cont) {
        if ($found = parser($a, $b, $line)) {
            $found_stack[] = $found;
            list ($a, $b) = [$a+$b, 1];
        } else {
            $b++;
        }
        $cont = (($a+$b) > $len) ? false : true;
    }

    if (count($found_stack) == 1) {
        $value = $found_stack[0] . $found_stack[0];
    } else if (count($found_stack) > 1) {
        $value = $found_stack[0] . $found_stack[count($found_stack)-1];
    }

    $answer += $value;
    if (count($found_stack) == 1 ) {
        echo "Line " . ($i + 1) ." : $line | Value: $value | Answer: $answer" . PHP_EOL;
    }
    unset($found_stack);

    // break; // only need first line
}

function parser(int $a, int $b, string &$line) {
    $check = substr($line, $a, $b);
    
    if (is_numeric(substr($check, -1))) { // check last char for numeric value
        return substr($check, -1);
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

echo "Answer: $answer " . PHP_EOL;
echo "Memory Usage: " . memory_get_peak_usage() . " bytes" . PHP_EOL;
echo "Processed Lines: $i" . PHP_EOL;