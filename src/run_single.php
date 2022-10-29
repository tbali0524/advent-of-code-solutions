<?php

/**
 * Advent of Code - CLI runner for a single solution.
 */

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

const FIRST_YEAR = 2015;
const LAST_YEAR = 2022;
const DAYS_PER_YEAR = 25;
$ansiRed = "\e[1;37;41m";
$ansiReset = "\e[0m";
$errorTag = $ansiRed . '[ERROR]' . $ansiReset . ' ';
$errorMsg = $errorTag . 'Invalid command line arguments' . PHP_EOL . 'Usage:  php src/run_single.php <year> <day>'
    . PHP_EOL;
if ($argc != 3) {
    echo $errorMsg;
    exit(1);
}
$year = intval(strtolower($argv[1]));
$day = intval(strtolower($argv[2]));
if (($year < FIRST_YEAR) or ($year > LAST_YEAR) or (($day < 1) or ($day > DAYS_PER_YEAR))) {
    echo $errorMsg;
    exit(1);
}
$className = 'Aoc' . $year . 'Day' . str_pad(strval($day), 2, '0', STR_PAD_LEFT);
$srcFileName = 'src/Aoc' . $year . '/' . $className . '.php';
if (!file_exists($srcFileName)) {
    echo $errorTag . 'Cannot find solution source file: ' . $srcFileName;
    exit(2);
}
$fullClassName = 'TBali\\Aoc' . $year . '\\' . $className;
/** @var TBali\Aoc\Solution */
$solution = new $fullClassName();
$result = $solution->run();
exit($result ? 0 : 3);
