<?php

$bag = ['red' => 12, 'green' => 13, 'blue' => 14];

$lines = file(getcwd() . DIRECTORY_SEPARATOR. 'datafile.txt');

$answer = 0; // 2943 (need bigger!),
for ($i = 0; $i < count($lines); $i++) {
    $sections = explode(':', rtrim($lines[$i]));
    $game_num = str_replace('Game ', '', $sections[0]);
    $tries = explode(';', trim($sections[1]));

    $good = true;
    foreach ($tries as $try) {
        $balls = explode(',', trim($try));
        array_map(function($ball) use (&$balls_new) {
            $parts = explode(' ', trim($ball));
            $balls_new[trim($parts[1])] = trim($parts[0]);
        }, $balls);

        $good = $good && validateAgainstBag($balls_new, $bag);
        unset($balls_new);
        if (!$good) {
            break;
        }
    }

    $answer += $good ? (int) $game_num : 0;
    echo "Game $game_num: good = " . (int) $good . ". Answer $answer. " .PHP_EOL;
}

function validateAgainstBag($balls_new, $bag) {
    foreach ($balls_new as $color => $count) {
        if (!isset($bag[$color])) {
            return false;
        } else if ((int) $count > $bag[$color]) {
            return false;
        }
    }
    return true;
}

