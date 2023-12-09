<?php

// 12 red cubes, 13 green cubes, and 14 blue cubes
$bag = [
    'red' => 12,
    'green' => 13,
    'blue' => 14
];

$lines = file(getcwd() . DIRECTORY_SEPARATOR. 'datafile.txt');

$answer = 0; // 2943 (need bigger!),
for ($i = 0; $i < count($lines); $i++) {
    $sections = explode(':', rtrim($lines[$i]));
    $game_num = str_replace('Game ', '', $sections[0]);
    $tries = explode(';', trim($sections[1]));

    $good = true;
    $all_trial = [];
    foreach ($tries as $try) {
        $balls = explode(',', trim($try));
        array_map(function($ball) use (&$balls_new) {
            $parts = explode(' ', trim($ball));
            $balls_new[trim($parts[1])] = trim($parts[0]);
        }, $balls);

        $good = $good && validateAgainstBag($balls_new, $bag);
        if (!$good) {
            // echo PHP_EOL . 'Bad. ' . json_encode($balls_new) . PHP_EOL;
            break;
        }
        unset($balls_new);
    }

    $answer += $good ? $game_num : 0;
    echo $lines[$i] . "Answer $answer. Game $game_num: good = " . (int) $good . PHP_EOL . PHP_EOL;
    // if ($i == 5) { break; }
}

function validateAgainstBag($balls_new, $bag) {
    foreach ($balls_new as $color => $count) {
        if (!isset($bag[$color])) {
            return false;
        } else if ($count > (int) $bag[$color]) {
            return false;
        }
    }
    return true;
}
