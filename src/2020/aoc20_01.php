<?php

/*
https://adventofcode.com/2020/day/1

Specifically, they need you to find the two entries that sum to 2020 and then multiply those two numbers together.
*/

declare(strict_types=1);

// ---------- read input
$input = [];
$myfile = fopen("input/aoc20_01.txt", "r")
  or die("Unable to open file!");
while (!feof($myfile)) {
    $s = fgets($myfile);
    if (($s != "") and ($s != "\n") and ($s != "\n\r")) {
        $input[] = intval($s);
    }
}
fclose($myfile);

// ---------- solve Day 1 Part 1
$startTime = microtime(true);
$ans = 0;
$visited = [];
foreach ($input as $i) {
    if (isset($visited[2020 - $i])) {
        $ans = $i * (2020 - $i);
        break;
    }
    $visited[$i] = true;
}
echo '=== Total time spent: ', number_format(microtime(true) - $startTime, 4, '.', ''), " sec", PHP_EOL;
echo '=== Max memory used:  ', number_format(memory_get_peak_usage(true), 0, '.', ','), " bytes", PHP_EOL;
echo '=== Result for Part 1:', PHP_EOL;
echo $ans, PHP_EOL;

// ---------- solve Day 1 Part 2
$startTime = microtime(true);
$ans = 0;
$visited = [];
foreach ($input as $idx => $i) {
    foreach ($input as $idx2 => $j) {
        if ($idx != $idx2) {
            $visited[$i + $j] = $i * $j;
        }
    }
}
foreach ($input as $i) {
    if (isset($visited[2020 - $i])) {
        $ans = $i * $visited[2020 - $i];
        break;
    }
}
echo '=== Total time spent: ', number_format(microtime(true) - $startTime, 4, '.', ''), " sec", PHP_EOL;
echo '=== Max memory used:  ', number_format(memory_get_peak_usage(true), 0, '.', ','), " bytes", PHP_EOL;
echo '=== Result for Part 2:', PHP_EOL;
echo $ans, PHP_EOL;
