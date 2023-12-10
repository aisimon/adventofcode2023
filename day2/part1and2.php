<?php

$bag = ['red' => 12, 'green' => 13, 'blue' => 14];
$lines = file(getcwd() . DIRECTORY_SEPARATOR. 'datafile.txt');
// $lines = file(getcwd() . DIRECTORY_SEPARATOR. 'test.txt'); // run against example data

// 3035, 66027
list ($answer1, $answer2) = [0, 0];

for ($i = 0; $i < count($lines); $i++) {
    $sections = explode(':', rtrim($lines[$i]));
    $game_num = str_replace('Game ', '', $sections[0]);
    $tries = explode(';', trim($sections[1]));

    list ($good, $balls_max) = [true, []];
    foreach ($tries as $try) {
        $balls = explode(',', trim($try));
        array_map(function($ball) use (&$balls_new) {
            $parts = explode(' ', trim($ball));
            $balls_new[trim($parts[1])] = trim($parts[0]);
        }, $balls);

        // This would not work, validateAgainstBag() should not be short circuited !
        // $good = $good && validateAgainstBag($balls_new, $bag, $balls_max);
        $good &= validateAgainstBag($balls_new, $bag, $balls_max);
        unset($balls_new);
    }

    $answer1 += $good ? (int) $game_num : 0;
    $answer2 += array_reduce(array_values($balls_max), "product", 1);

    echo "Game $game_num: ". (($good)?"Good":"Not Good");
    echo ". Answer 1 = $answer1 Answer 2 = $answer2" .PHP_EOL;
    unset($balls_max);
}

function validateAgainstBag($balls_new, $bag, &$balls_max) {
    $valid = true;
    foreach ($balls_new as $color => $count) {
        if ($count > $bag[$color]) {
            $valid = false;
        }
        $balls_max[$color] = (!isset($balls_max[$color]) ? $count : max($balls_max[$color], $count));
    }
    return $valid;
}

function product($carry, $item)
{
    return ($carry *= $item);
}
