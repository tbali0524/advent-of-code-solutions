<?php

// aoc_run v1.0 - batch solution runner for Advent of Code, (c) 2022 by TBali

declare(strict_types=1);

// --------------------------------------------------------------------
$startTime = hrtime(true);
echo 'aoc_run v1.0 - batch solution runner for Advent of Code, (c) 2022 by TBali' . PHP_EOL;
const FIRST_YEAR = 2015;
const LAST_YEAR = 2022;
const DAYS_PER_YEAR = 25;
const SOURCE_EXTENSION = '.php';
const RUN_COMMAND = 'php';
const TO_SKIP = [
    2015 => [20, 24],
];
$selectedYear = 0;
if ($argc > 1) {
    $arg = strtolower($argv[1]);
    $selectedYear = intval($arg);
    if (($argc > 2) or !is_numeric($arg) or ($selectedYear < FIRST_YEAR) or ($selectedYear > LAST_YEAR)) {
        echo PHP_EOL . 'Usage:  php aoc_run.php [year]' . PHP_EOL;
        exit(0);
    }
}
$countRuns = 0;
for ($year = FIRST_YEAR; $year <= LAST_YEAR; ++$year) {
    if (($selectedYear > 0) and ($year != $selectedYear)) {
        continue;
    }
    echo '======= ' . $year . ' ===========================' . PHP_EOL;
    for ($day = 1; $day <= DAYS_PER_YEAR; ++$day) {
        if (in_array($day, TO_SKIP[$year] ?? [])) {
            continue;
        }
        $srcFileName = 'src/' . strval($year) . '/aoc'
            . str_pad(strval($year % 100), 2, '0', STR_PAD_LEFT) . '_'
            . str_pad(strval($day), 2, '0', STR_PAD_LEFT) . SOURCE_EXTENSION;
        if (!file_exists($srcFileName)) {
            continue;
        }
        $runCommand = RUN_COMMAND . ' ' . $srcFileName;
        if (PHP_OS_FAMILY == 'Windows') {
            $runCommand = str_replace('/', '\\', $runCommand);
        }
        $execOutput = [];
        $execResultCode = 0;
        $execResult = system($runCommand, $execResultCode);
        if (($execResult === false) or ($execResultCode != 0)) {
            echo '*** execution failed for ' . $srcFileName . PHP_EOL;
        } else {
            ++$countRuns;
        }
    }
}
$spentTime = number_format((hrtime(true) - $startTime) / 1000_000_000, 4, '.', '');
echo '======= Total: ' . $countRuns . ' solutions [time: ' . $spentTime . ' sec]' . PHP_EOL;
