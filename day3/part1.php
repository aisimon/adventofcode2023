<?php

$lines = file(getcwd().'/test.txt');

for ($i = 0; $i < count($lines); $i++) {
    $numbers[] = readInLine(rtrim($lines[$i]));
    echo json_encode($numbers) . PHP_EOL;

}

list ($answer1, $answer2) = [0, 0];


// e.g.  {"12":{"start":1,"end":2},"2":{"start":4,"end":4},"
function readInLine($line) {
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
                $numbers[] = [
                    'start' => $start,
                    'end' => $i - 1,
                    'n' => substr($line, $start, $i - $start)
                ];
                list ($numbers_char, $found, $start) = ['', false, -1];
            }
        }
    }
    if ($found) {
        $numbers[] = [
            'start' => $start,
            'end' => $i - 1,
            'n' => substr($line, $start, $i - $start)
        ];
    }
    return $numbers;
}