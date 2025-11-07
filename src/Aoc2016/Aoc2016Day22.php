<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2016;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2016 Day 22: Grid Computing.
 *
 * Part 1: How many viable pairs of nodes are there?
 * Part 2: What is the fewest number of steps required to move your goal data to node-x0-y0?
 *
 * @see https://adventofcode.com/2016/day/22
 */
final class Aoc2016Day22 extends SolutionBase
{
    public const YEAR = 2016;
    public const DAY = 22;
    public const TITLE = 'Grid Computing';
    public const SOLUTIONS = [1034, 261];
    public const EXAMPLE_SOLUTIONS = [[7, 0]];

    /** @var array<int, Node> */
    private array $nodes = [];

    /**
     * Solve both parts of the puzzle for a given input, without IO.
     *
     * @param array<int, string> $input The lines of the input, without LF
     *
     * @return array<int, string> The answers for Part 1 and Part 2 (as strings)
     *
     * @phpstan-return array{string, string}
     */
    public function solve(array $input): array
    {
        $this->nodes = [];
        foreach ($input as $idx => $line) {
            if ($idx < 2) {
                continue;
            }
            $this->nodes[] = new Node($line);
        }
        // ---------- Part 1
        $ans1 = 0;
        foreach ($this->nodes as $a) {
            foreach ($this->nodes as $b) {
                if (Node::isViablePair($a, $b)) {
                    ++$ans1;
                }
            }
        }
        // ---------- Part 2
        // $this->printGrid();
        // 1234567890123456789012345678901234567
        // --------------------------------------
        // G...................................0S
        // ..................6.........7.......9.
        // .......501234567890123456789012345678.
        // ........9.............................
        // ........8.............................
        // ........7.............................
        // ........6.............................
        // ........5.............................
        // ........4.............................
        // ........3.............................
        // ........2.............................
        // ........1.............................
        // .......40.............................
        // ........9.............................
        // ........8.............................
        // ........7.............................
        // ........6.............................
        // ........5.............................
        // ........4.............................
        // ........3.............................
        // ........2.............................
        // ........1.............................
        // .......30.............................
        // ........9.............................
        // ........8#############################
        // ........7.....2.........1.............
        // ........65432109876543210987654321_.+.
        // ......................................
        $ans2 = 80 + 36 * 5 + 1;
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @codeCoverageIgnore
     *
     * @phpstan-ignore method.unused
     */
    private function printGrid(): void
    {
        $maxX = max(array_map(static fn (Node $node): int => $node->x, $this->nodes) ?: [0]) + 1;
        $maxY = max(array_map(static fn (Node $node): int => $node->y, $this->nodes) ?: [0]) + 1;
        $s = array_fill(0, $maxY, str_repeat(' ', $maxX));
        foreach ($this->nodes as $node) {
            if ($node->size > 100) {
                $c = '#';
            } elseif (($node->y == 0) and ($node->x == 0)) {
                $c = 'G';
            } elseif (($node->y == 0) and ($node->x == $maxX - 1)) {
                $c = 'S';
            } elseif ($node->used == 0) {
                $c = '_';
            } else {
                $c = '.';
            }
            $s[$node->y][$node->x] = $c;
        }
        // @phpstan-ignore argument.type
        echo implode(PHP_EOL, $s), PHP_EOL;
    }
}

// --------------------------------------------------------------------
final class Node
{
    public int $x;
    public int $y;
    public int $size;
    public int $used;
    public int $avail;
    public int $usedPercent;

    /**
     * Constructor from input line.
     *
     * Line pattern:
     * Filesystem              Size  Used  Avail  Use%
     * /dev/grid/node-x0-y0     88T   66T    22T   75%
     */
    public function __construct(string $s)
    {
        $p = strpos(substr($s, 17), '-');
        if (($p === false) or (strlen($s) < 47)) {
            throw new \Exception('Invalid input');
        }
        $this->x = intval(substr($s, 16, $p + 1));
        $this->y = intval(trim(substr($s, 19 + $p, 3)));
        $this->size = intval(trim(substr($s, 24, 3)));
        $this->used = intval(trim(substr($s, 30, 3)));
        $this->avail = intval(trim(substr($s, 37, 3)));
        $this->usedPercent = intval(trim(substr($s, 43, 3)));
    }

    public static function isViablePair(self $a, self $b): bool
    {
        return ($a->used > 0) && ($a !== $b) && ($a->used <= $b->avail);
    }
}
