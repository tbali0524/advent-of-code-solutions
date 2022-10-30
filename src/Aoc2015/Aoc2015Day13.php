<?php

/*
https://adventofcode.com/2015/day/13
Part 1: What is the total change in happiness for the optimal seating arrangement of the actual guest list?
Part 2: What is the total change in happiness for the optimal seating arrangement that actually includes yourself?
topics: permutations, Heap's algorithm, Hamiltonian circle
*/

// phpcs:disable PSR1.Classes.ClassDeclaration

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

class Aoc2015Day13 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 13;
    public const TITLE = 'Knights of the Dinner Table';
    public const SOLUTIONS = [709, 668];
    public const EXAMPLE_SOLUTIONS = [[330, 0], [0, 0]];

    /**
     * @param string[] $input
     *
     * @return array{string, string}
     */
    public function solve(array $input): array
    {
        // ---------- Part 1
        $g = new KnightsTable($input);
        $ans1 = $g->getMaxHappiness();
        // ---------- Part 2
        $g->addZeroNode();
        $ans2 = $g->getMaxHappiness();
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
class KnightsTable
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
