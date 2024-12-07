<?php

$input = file_get_contents('./input.txt');
$input = array_filter(explode(PHP_EOL, $input));
$rows = count($input);
$cols = strlen($input[0]);

$words = 0;
for ($i = 0; $i < $rows; $i++) {
    for ($j = 0; $j < $cols; $j++) {
        $words += upperRight($i, $j);
        $words += right($i, $j);
        $words += lowerRight($i, $j);
        $words += down($i, $j);
    }
}

echo "Words: $words\n";

function down(int $i, int $j): int
{
    global $input, $rows;
    if ($input[$i][$j] !== 'X' && $input[$i][$j] !== 'S') {
        return 0;
    }
    if ($i + 3 >= $rows) {
        return 0;
    }
    $word = $input[$i][$j].$input[$i + 1][$j].$input[$i + 2][$j].$input[$i + 3][$j];
    return in_array($word, ['XMAS', 'SAMX']);
}

function right(int $i, int $j): int
{
    global $input, $cols;

    if ($input[$i][$j] !== 'X' && $input[$i][$j] !== 'S') {
        return 0;
    }
    if ($j + 3 >= $cols) {
        return 0;
    }
    $word = $input[$i][$j].$input[$i][$j + 1].$input[$i][$j + 2].$input[$i][$j + 3];
    return in_array($word, ['XMAS', 'SAMX']);
}

function lowerRight(int $i, int $j): int
{
    global $input, $rows, $cols;

    if ($input[$i][$j] !== 'X' && $input[$i][$j] !== 'S') {
        return 0;
    }
    if ($i + 3 >= $rows || $j + 3 >= $cols) {
        return 0;
    }
    $word = $input[$i][$j].$input[$i + 1][$j + 1].$input[$i + 2][$j + 2].$input[$i + 3][$j + 3];
    return in_array($word, ['XMAS', 'SAMX']);
}

function upperRight(int $i, int $j): int
{
    global $input, $rows, $cols;

    if ($input[$i][$j] !== 'X' && $input[$i][$j] !== 'S') {
        return 0;
    }
    if ($i - 3 < 0 || $j + 3 >= $cols) {
        return 0;
    }
    $word = $input[$i][$j].$input[$i - 1][$j + 1].$input[$i - 2][$j + 2].$input[$i - 3][$j + 3];
    return in_array($word, ['XMAS', 'SAMX']);
}
