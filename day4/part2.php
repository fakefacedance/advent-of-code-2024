<?php

$input = file_get_contents('./input.txt');
$input = array_filter(explode(PHP_EOL, $input));
$rows = count($input);
$cols = strlen($input[0]);

$words = 0;
for ($i = 0; $i < $rows; $i++) {
    for ($j = 0; $j < $cols; $j++) {
        if ($i + 2 >= $cols || $j + 2 >= $rows) {
            continue;
        }
        $words += in_array($input[$i][$j].$input[$i + 1][$j + 1].$input[$i + 2][$j + 2], ['MAS', 'SAM'])
            && in_array($input[$i][$j + 2].$input[$i + 1][$j + 1].$input[$i + 2][$j], ['MAS', 'SAM']);
    }
}

echo "Words: $words\n";
