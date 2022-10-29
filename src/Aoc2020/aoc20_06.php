<?php

/*
https://adventofcode.com/2020/day/6
Part 1: For each group, count the number of questions to which anyone answered "yes". What is the sum of those counts?
Part 2: Count the number of questions to which everyone answered "yes". What is the sum of those counts?
*/

declare(strict_types=1);

// --------------------------------------------------------------------
const YEAR = 2020;
const DAY = '06';
const TITLE = 'Custom Customs';
const SOLUTION1 = 6291;
const SOLUTION2 = 3052;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc20_06.txt', 'r');
if ($handle === false) {
    throw new \Exception('Cannot load input file');
}
$input = [[]];
while (true) {
    $line = fgets($handle);
    if ($line === false) {
        break;
    }
    if (trim($line) == '') {
        $input[] = [];
        continue;
    }
    $input[count($input) - 1][] = trim($line);
}
fclose($handle);
// --------------------------------------------------------------------
// Part 1
$ans1 = array_sum(array_map(
    // count_chars mode = 3: a string containing all unique characters is returned.
    // @phpstan-ignore-next-line
    fn ($group) => strlen(count_chars(implode('', $group), 3)),
    $input
));
// --------------------------------------------------------------------
// Part 2
$ans2 = array_sum(array_map(
    // count_chars mode = 1: an array with the byte-value as key and the frequency of every byte as value,
    //      only byte-values with a frequency greater than zero are listed.
    fn ($group) => count(array_filter(
        // @phpstan-ignore-next-line
        count_chars(implode('', $group), 1),
        fn ($value) => $value == count($group),
    )),
    $input
));
// ----------
$spentTime = number_format((hrtime(true) - $startTime) / 1000_000_000, 4, '.', '');
$maxMemory = strval(ceil(memory_get_peak_usage(true) / 1000_000));
echo '=== AoC ' . YEAR . ' Day ' . DAY . ' [time: ' . $spentTime . ' sec, memory: ' . $maxMemory . ' MB]: ' . TITLE
    . PHP_EOL;
echo $ans1, PHP_EOL;
if ($ans1 != SOLUTION1) {
    echo '*** WRONG ***', PHP_EOL;
}
echo $ans2, PHP_EOL;
if ($ans2 != SOLUTION2) {
    echo '*** WRONG ***', PHP_EOL;
}
