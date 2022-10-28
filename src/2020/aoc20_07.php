<?php

/*
https://adventofcode.com/2020/day/7
Part 1: How many bag colors can eventually contain at least one shiny gold bag?
Part 2: How many individual bags are required inside your single shiny gold bag?
*/

// phpcs:disable PSR1.Files.SideEffects, PSR1.Classes.ClassDeclaration

declare(strict_types=1);

namespace TBali\Aoc20_07;

// --------------------------------------------------------------------
const YEAR = 2020;
const DAY = '07';
const TITLE = 'Handy Haversacks';
const SOLUTION1 = 115;
const SOLUTION2 = 1250;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc20_07.txt', 'r');
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
// Part 1 + 2
$g = new BagRegulations($input);
$ans1 = $g->getSumContainerBags('shiny gold');
$ans2 = $g->getSumContainedBags('shiny gold');
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
class BagRegulations
{
    /** @var array<string, array<string, int>> */
    public array $contains = [];
    /** @var array<string, string[]> */
    public array $containedBy = [];

    /** @param string[] $input */
    public function __construct(array $input = [])
    {
        foreach ($input as $line) {
            $a = explode(' ', $line);
            if ((count($a) < 7) or ($a[2] != 'bags') or ($a[3] != 'contain')) {
                throw new \Exception('Invalid input');
            }
            $bag = $a[0] . ' ' . $a[1];
            $this->contains[$bag] = [];
            if ((count($a) == 7) and ($a[4] == 'no') and ($a[5] == 'other') and ($a[6] == 'bags.')) {
                continue;
            }
            if (count($a) % 4 != 0) {
                throw new \Exception('Invalid input');
            }
            for ($i = 1; $i < intdiv(count($a), 4); ++$i) {
                if (!is_numeric($a[4 * $i]) or !in_array($a[4 * $i + 3], ['bag,', 'bags,', 'bag.', 'bags.'])) {
                    throw new \Exception('Invalid input');
                }
                $innerBag = $a[4 * $i + 1] . ' ' . $a[4 * $i + 2];
                $this->contains[$bag][$innerBag] = intval($a[4 * $i]);
                if (!isset($this->containedBy[$innerBag])) {
                    $this->containedBy[$innerBag] = [];
                }
                $this->containedBy[$innerBag][] = $bag;
            }
        }
    }

    public function getSumContainerBags(string $bag): int
    {
        $bags = [];
        $q = [$bag];
        while (count($q) > 0) {
            $currentBag = array_shift($q);
            foreach ($this->containedBy[$currentBag] ?? [] as $containerBag) {
                if (isset($bags[$containerBag])) {
                    continue;
                }
                $bags[$containerBag] = true;
                $q[] = $containerBag;
            }
        }
        return count($bags);
    }

    public function getSumContainedBags(string $bag): int
    {
        static $memo = [];

        if (isset($memo[$bag])) {
            return $memo[$bag];
        }
        $ans = 0;
        foreach ($this->contains[$bag] ?? [] as $containedBag => $count) {
            $ans += $count * ($this->getSumContainedBags($containedBag) + 1);
        }
        $memo[$bag] = $ans;
        return $ans;
    }
}
