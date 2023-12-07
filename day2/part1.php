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
            $balls_new[$parts[1]] = $parts[0];
        }, $balls);

        // echo json_encode($balls_new, JSON_PRETTY_PRINT) . PHP_EOL;
        storeTry($balls_new, $all_trial);
        unset($balls_new);
    }

    $good = validateAgainstBag($all_trial, $bag);
    echo "Game $game_num: good = " . (int) $good . PHP_EOL;
    $answer += $good ? $game_num : 0;
    break;
}

echo $answer . PHP_EOL;

function validateAgainstBag($balls_new, $bag) {
    foreach ($balls_new as $color => $count) {
        if (!isset($bag[$color])) {
            return false;
        } else if ($count > $bag[$color]) {
            return false;
        }
    }
    return true;
}

function storeTry($try, &$all_trial) {
    foreach ($try as $color => $count) {
        if (!isset($all_trial[$color])) {
            $all_trial[$color] = $count;
        } else {
            $all_trial[$color] += $count;
        }
    }
}