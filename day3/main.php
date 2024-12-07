<?php

function getSum(string $input): int
{
    $sum = 0;
    preg_match_all('/mul\((\d{1,3}),(\d{1,3})\)/', $input, $matches);
    for ($i = 0; $i < count($matches[0]); $i++) {
        $sum += $matches[1][$i] * $matches[2][$i];
    }

    return $sum;
}

function part1(): int
{
    $input = file_get_contents('./input.txt');

    return getSum($input);
}

function part2(): int
{
    $input = file_get_contents('./input.txt');
    $input = str_replace("\n", '', $input);
    $tokens = explode("don't()", $input);
    $sum = 0;

    foreach ($tokens as $i => $token) {
        if ($i === 0) {
            $sum += getSum($token);
            continue;
        }
        $instructions = explode('do()', $token);
        if (count($instructions) === 1) { // no "do()" between "don't()"s
            continue;
        }
        for ($i = 1; $i < count($instructions); $i++) {
            $sum += getSum($instructions[$i]);
        }
    }

    return $sum;
}

echo 'Part 1: ' . part1() . PHP_EOL;
echo 'Part 2: ' . part2() . PHP_EOL;
