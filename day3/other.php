<?php

$lines = file(getcwd().'/test.txt');

list ($answer1, $answer2) = [0, 0];
for ($i = 0; $i < count($lines); $i++) {

    $numbers = readInLine_really_dump(rtrim($lines[$i]));

    echo json_encode($numbers) . PHP_EOL;

}

/**
 * My first attempt at reading in the line, the dump one :P
 *
 * @param string $line
 * @return void
 */
function readInLine_really_dump($line) {
    $numbers = [];
    list ($numbers_char, $found, $start) = ['', false, -1];
    for ($i = 0; $i < strlen($line); $i++) {
        $char = $line[$i];
        if (is_numeric($char)) {
            $numbers_char .= $char;
            $found = true;
            if ($start == -1) {
                $start = $i;
            }
        } else {
            if ($found) {
                $numbers[] = substr($line, $start, $i - $start);
                list ($numbers_char, $found, $start) = ['', false, -1];
            }
        }
    }
    if ($found) {
        $numbers[] = substr($line, $start, $i - $start);
    }
    return $numbers;
}


// If we just want the numbers with positions
function wantNumbersONly($line) {
    $pattern = "/\D+/";
    $replacement = "."; 
    $result = explode(".", preg_replace($pattern, $replacement, $line));
    return $result;
}