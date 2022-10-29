<?php

/*
https://adventofcode.com/2015/day/14
Part 1: After exactly 2503 seconds, what distance has the winning reindeer traveled?
Part 2: After exactly 2503 seconds, how many points does the winning reindeer have?
*/

// phpcs:disable PSR1.Files.SideEffects, PSR1.Classes.ClassDeclaration

declare(strict_types=1);

namespace TBali\Aoc15_14;

// --------------------------------------------------------------------
const YEAR = 2015;
const DAY = '14';
const TITLE = 'Reindeer Olympic';
const SOLUTION1 = 2696;
const SOLUTION2 = 1084;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc15_14.txt', 'r');
if ($handle === false) {
    throw new \Exception('Cannot load input file');
}
$input = [];
while (true) {
    $line = fgets($handle);
    if ($line === false) {
        break;
    }
    if (trim($line) == '') {
        continue;
    }
    $input[] = trim($line);
}
fclose($handle);
// --------------------------------------------------------------------
// Part 1
const MAX = 2503;
$ans1 = max(array_map(fn ($line) => (new Reindeer($line))->getDistanceAt(MAX), $input));
// --------------------------------------------------------------------
// Part 2
$reindeers = [];
foreach ($input as $line) {
    $reindeers[] = new Reindeer($line);
}
for ($second = 1; $second <= MAX; ++$second) {
    $max = max(array_map(fn ($x) => $x->getDistanceAt($second), $reindeers));
    array_walk(
        $reindeers,
        function ($x) use ($second, $max) {
            if ($x->getDistanceAt($second) == $max) {
                ++$x->points;
            }
        }
    );
}
$ans2 = max(array_map(fn ($x) => $x->points, $reindeers));
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

// --------------------------------------------------------------------
class Reindeer
{
    public string $name;
    public int $speed;
    public int $flyTime;
    public int $restTime;
    public int $points;

    public function __construct(string $line)
    {
        $a = explode(' ', $line);
        if (
            (count($a) != 15)
            or !is_numeric($a[3])
            or !is_numeric($a[6])
            or !is_numeric($a[13])
            or ($a[1] != 'can')
            or ($a[2] != 'fly')
            or ($a[4] != 'km/s')
            or ($a[5] != 'for')
            or ($a[14] != 'seconds.')
            or !str_contains($line, ' seconds, but then must rest for ')
        ) {
            throw new \Exception('Invalid input');
        }
        $this->name = $a[0];
        $this->speed = intval($a[3]);
        $this->flyTime = intval($a[6]);
        $this->restTime = intval($a[13]);
        $this->points = 0;
    }

    public function getDistanceAt(int $seconds): int
    {
        $cycles = intdiv($seconds, $this->flyTime + $this->restTime);
        $remaining = min($this->flyTime, $seconds % ($this->flyTime + $this->restTime));
        return $this->speed * ($cycles * $this->flyTime + $remaining);
    }
}
