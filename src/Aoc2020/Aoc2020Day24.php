<?php

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2020 Day 24: Lobby Layout.
 *
 * Part 1: After all of the instructions have been followed, how many tiles are left with the black side up?
 * Part 2: After executing this process a total of 100 times, there would be 2208 black tiles facing up.
 *
 * Topics: walking simulator on hex grid, Conway's Game of Life
 *
 * @see https://adventofcode.com/2020/day/
 */
final class Aoc2020Day24 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 24;
    public const TITLE = 'Lobby Layout';
    public const SOLUTIONS = [391, 3876];
    public const EXAMPLE_SOLUTIONS = [[10, 2208]];

    private const MOVES = ['nw' => 0, 'ne' => 1, 'w' => 2, 'e' => 3, 'sw' => 4, 'se' => 5];
    private const EVEN_NB = [[-1, -1], [0, -1], [-1, 0], [1, 0], [-1, 1], [0, 1]];
    private const ODD_NB = [[0, -1], [1, -1], [-1, 0], [1, 0], [0, 1], [1, 1]];
    private const MAX_STEPS = 100;

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
        // ---------- Part 1
        $ans1 = 0;
        $flipped = [];
        foreach ($input as $line) {
            $x = 0;
            $y = 0;
            $i = 0;
            while ($i < strlen($line)) {
                if (str_contains('sn', $line[$i])) {
                    $dir = substr($line, $i, 2);
                    ++$i;
                } else {
                    $dir = $line[$i];
                }
                if (!isset(self::MOVES[$dir])) {
                    throw new \Exception('Invalid input');
                }
                $idxDir = self::MOVES[$dir];
                [$dx, $dy] = $y % 2 == 0 ? self::EVEN_NB[$idxDir] : self::ODD_NB[$idxDir];
                $x += $dx;
                $y += $dy;
                ++$i;
            }
            if ($flipped[$y][$x] ?? false) {
                unset($flipped[$y][$x]);
                --$ans1;
            } else {
                $flipped[$y][$x] = true;
                ++$ans1;
            }
        }
        // ---------- Part 2
        $prevTiles = [];
        foreach ($flipped as $y => $flipRow) {
            foreach ($flipRow as $x => $true) {
                $prevTiles[] = [$x, $y];
            }
        }
        for ($step = 0; $step < self::MAX_STEPS; ++$step) {
            $toCheckList = [];
            $toCheckMap = [];
            $prevGrid = [];
            foreach ($prevTiles as [$x, $y]) {
                if (!isset($toCheckMap[$y][$x])) {
                    $toCheckList[] = [$x, $y];
                    $toCheckMap[$y][$x] = true;
                }
                $prevGrid[$y][$x] = true;
                $nbDeltas = $y % 2 == 0 ? self::EVEN_NB : self::ODD_NB;
                foreach ($nbDeltas as [$dx, $dy]) {
                    [$x1, $y1] = [$x + $dx, $y + $dy];
                    if (isset($toCheckMap[$y1][$x1])) {
                        continue;
                    }
                    $toCheckList[] = [$x1, $y1];
                    $toCheckMap[$y1][$x1] = true;
                }
            }
            $nextTiles = [];
            foreach ($toCheckList as [$x, $y]) {
                $count = 0;
                $nbDeltas = $y % 2 == 0 ? self::EVEN_NB : self::ODD_NB;
                foreach ($nbDeltas as [$dx, $dy]) {
                    [$x1, $y1] = [$x + $dx, $y + $dy];
                    if (isset($prevGrid[$y1][$x1])) {
                        ++$count;
                    }
                }
                if (
                    (isset($prevGrid[$y][$x]) and (($count == 1) or ($count == 2)))
                    or (!isset($prevGrid[$y][$x]) and ($count == 2))
                ) {
                    $nextTiles[] = [$x, $y];
                }
            }
            $prevTiles = $nextTiles;
        }
        $ans2 = count($nextTiles);
        return [strval($ans1), strval($ans2)];
    }
}
