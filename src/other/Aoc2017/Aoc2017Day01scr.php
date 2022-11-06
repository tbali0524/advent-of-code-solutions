<?php

// https://adventofcode.com/2017/day/1

declare(strict_types=1);

const YEAR = 2017;
const DAY = 1;
const TITLE = 'Inverse Captcha';

echo '=== AoC ' . YEAR . ' Day ' . DAY . ' : ' . TITLE . PHP_EOL;
// ---------- Part 1
$line = '91212129';
$ans1 = 0;
for ($i = 0; $i < strlen($line); ++$i) {
    if ($line[$i] == $line[($i + 1) % strlen($line)]) {
        $ans1 += intval($line[$i]);
    }
}
echo $ans1, PHP_EOL;
// ---------- Part 2
$line = '12131415';
$ans2 = 0;
for ($i = 0; $i < strlen($line); ++$i) {
    if ($line[$i] == $line[($i + intdiv(strlen($line), 2)) % strlen($line)]) {
        $ans2 += intval($line[$i]);
    }
}
echo $ans2, PHP_EOL;
