<?php

/*
https://adventofcode.com/2015/day/13
Part 1: What is the total change in happiness for the optimal seating arrangement of the actual guest list?
Part 2: What is the total change in happiness for the optimal seating arrangement that actually includes yourself?
topics: permutations, Heap's algorithm, Hamiltonian circle
*/

// phpcs:disable PSR1.Files.SideEffects, PSR1.Classes.ClassDeclaration

declare(strict_types=1);

namespace TBali\Aoc15_13;

// --------------------------------------------------------------------
const YEAR = 2015;
const DAY = '13';
const TITLE = 'Knights of the Dinner Table';
const SOLUTION1 = 709;
const SOLUTION2 = 668;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/' . YEAR . '/aoc15_13.txt', 'r');
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
$g = new Graph($input);
$ans1 = $g->getMaxHappiness();
// --------------------------------------------------------------------
// Part 2
$g->addZeroNode();
$ans2 = $g->getMaxHappiness();
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
class Graph
{
    public int $v = 0;
    /** @var array<string, int> */
    public array $nodes = [];
    /** @var array<int, int[]> */
    public array $dist = [];

    /** @param string[] $input */
    public function __construct(array $input)
    {
        foreach ($input as $line) {
            $a = explode(' ', $line);
            if (
                (count($a) != 11)
                or !is_numeric($a[3])
                or ($a[1] != 'would')
                or !str_contains($line, ' happiness units by sitting next to ')
            ) {
                throw new \Exception('Invalid input');
            }
            $id1 = $this->addOrGetNode($a[0]);
            $id2 = $this->addOrGetNode(substr($a[10], 0, -1));
            if ($id1 == $id2) {
                throw new \Exception('Invalid input');
            }
            if ($a[2] == 'gain') {
                $sign = 1;
            } elseif ($a[2] == 'lose') {
                $sign = -1;
            } else {
                throw new \Exception('Invalid input');
            }
            $this->dist[$id1][$id2] = $sign * intval($a[3]);
        }
        $this->v = count($this->nodes);
    }

    public function addZeroNode(): void
    {
        $this->nodes['myself'] = $this->v;
        for ($i = 0; $i < $this->v; ++$i) {
            $this->dist[$i][$this->v] = 0;
            $this->dist[$this->v][$i] = 0;
        }
        ++$this->v;
    }

    public function addOrGetNode(string $name): int
    {
        if (isset($this->nodes[$name])) {
            return $this->nodes[$name];
        }
        $id = count($this->nodes);
        $this->nodes[$name] = $id;
        return $id;
    }

    // generating all permutations vertices (path order), checks minimum total distance
    // based on https://en.wikipedia.org/wiki/Heap%27s_algorithm
    public function getMaxHappiness(): int
    {
        $a = range(0, $this->v - 1);
        $c = array_fill(0, $this->v, 0);
        $max = $this->dist[$a[$this->v - 1]][$a[0]] + $this->dist[$a[0]][$a[$this->v - 1]];
        for ($j = 1; $j < $this->v; ++$j) {
            $max += $this->dist[$a[$j - 1]][$a[$j]] + $this->dist[$a[$j]][$a[$j - 1]];
        }
        $i = 1;
        while ($i < $this->v) {
            if ($c[$i] < $i) {
                if ($i % 2 == 0) {
                    $t = $a[0];
                    $a[0] = $a[$i];
                    $a[$i] = $t;
                } else {
                    $t = $a[$c[$i]];
                    $a[$c[$i]] = $a[$i];
                    $a[$i] = $t;
                }
                $circle = $this->dist[$a[$this->v - 1]][$a[0]] + $this->dist[$a[0]][$a[$this->v - 1]];
                for ($j = 1; $j < $this->v; ++$j) {
                    $circle += $this->dist[$a[$j - 1]][$a[$j]] + $this->dist[$a[$j]][$a[$j - 1]];
                }
                $max = max($max, $circle);
                ++$c[$i];
                $i = 1;
                continue;
            }
            $c[$i] = 0;
            ++$i;
        }
        return $max;
    }
}
