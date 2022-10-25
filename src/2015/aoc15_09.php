<?php

/*
https://adventofcode.com/2015/day/9
Part 1: What is the distance of the shortest route?
Part 2: What is the distance of the longest route?
topics: permutations, Heap's algorithm, Hamiltonian paths
*/

// phpcs:disable PSR1.Files.SideEffects, PSR1.Classes.ClassDeclaration

declare(strict_types=1);

namespace TBali\Aoc15_09;

// --------------------------------------------------------------------
const YEAR = 2015;
const DAY = '09';
const TITLE = 'All in a Single Night';
const SOLUTION1 = 207;
const SOLUTION2 = 804;
$startTime = hrtime(true);
// ----------
$handle = fopen('input/aoc15_09.txt', 'r');
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
$g = new Graph($input);
[$ans1, $ans2] = $g->getMinMaxDistance();
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
            $a = explode(' = ', $line);
            if ((count($a) != 2) or !is_numeric($a[1])) {
                throw new \Exception('Invalid input');
            }
            $b = explode(' to ', $a[0]);
            if (count($b) != 2) {
                throw new \Exception('Invalid input');
            }
            $id1 = $this->addOrGetNode($b[0]);
            $id2 = $this->addOrGetNode($b[1]);
            if ($id1 == $id2) {
                throw new \Exception('Invalid input');
            }
            $this->dist[$id1][$id2] = intval($a[1]);
            $this->dist[$id2][$id1] = $this->dist[$id1][$id2];
        }
        $this->v = count($this->nodes);
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
    /** @return int[] */
    public function getMinMaxDistance(): array
    {
        $a = range(0, $this->v - 1);
        $c = array_fill(0, $this->v, 0);
        $min = 0;
        for ($j = 1; $j < $this->v; ++$j) {
            $min += $this->dist[$a[$j - 1]][$a[$j]];
        }
        $max = $min;
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
                $path = 0;
                for ($j = 1; $j < $this->v; ++$j) {
                    $path += $this->dist[$a[$j - 1]][$a[$j]];
                }
                $min = min($min, $path);
                $max = max($max, $path);
                ++$c[$i];
                $i = 1;
                continue;
            }
            $c[$i] = 0;
            ++$i;
        }
        return [$min, $max];
    }
}
