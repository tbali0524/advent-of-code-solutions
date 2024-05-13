<?php

declare(strict_types=1);

namespace TBali\Aoc2023;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2023 Day 18: Lavaduct Lagoon.
 *
 * Part 1: If they follow their dig plan, how many cubic meters of lava could it hold?
 * Part 2: If the Elves follow this new dig plan, how many cubic meters of lava could the lagoon hold?
 *
 * @see https://adventofcode.com/2023/day/18
 */
final class Aoc2023Day18 extends SolutionBase
{
    public const YEAR = 2023;
    public const DAY = 18;
    public const TITLE = 'Lavaduct Lagoon';
    public const SOLUTIONS = [40131, 104454050898331];
    public const EXAMPLE_SOLUTIONS = [[62, 952408144115]];

    private const DEBUG = false;
    private const DIRS = 'RDLU';
    private const DELTA_XY = [
        'R' => [1, 0],
        'D' => [0, 1],
        'L' => [-1, 0],
        'U' => [0, -1],
    ];

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
        // ---------- Parse input
        $maxCommands = count($input);
        $directions = '';
        $directionsPart2 = '';
        $steps = [];
        foreach ($input as $line) {
            $a = explode(' ', $line);
            if ((count($a) != 3) or !str_contains('URDL', $a[0]) or (strlen($a[2]) != 9)) {
                throw new \Exception('Invalid input');
            }
            $directions .= $a[0];
            $steps[] = intval($a[1]);
            $directionsPart2 .= self::DIRS[intval(hexdec($a[2][7]))] ?? throw new \Exception('Invalid input');
            $stepsPart2[] = intval(hexdec(substr($a[2], 2, 5)));
        }
        // ---------- Part 1
        $minX = 0;
        $maxX = 0;
        $minY = 0;
        $maxY = 0;
        // traverse loop, fill out edgeBlock[] and compute x,y boundaries
        $x = 0;
        $y = 0;
        $edgeBlocks = ['0 0' => true];
        for ($i = 0; $i < $maxCommands; ++$i) {
            [$dx, $dy] = self::DELTA_XY[$directions[$i]];
            for ($j = 0; $j < $steps[$i]; ++$j) {
                $x += $dx;
                $y += $dy;
                $hash = $x . ' ' . $y;
                $edgeBlocks[$hash] = true;
            }
            $minX = intval(min($x, $minX));
            $maxX = intval(max($x, $maxX));
            $minY = intval(min($y, $minY));
            $maxY = intval(max($y, $maxY));
        }
        // BFS from corner, add +1 pixels around the border to the search area
        $x = $minX - 1;
        $y = $minY - 1;
        $hash = $x . ' ' . $y;
        $outsideBlocks = [$hash => true];
        $q = [[$x, $y]];
        $idxRead = 0;
        while (true) {
            if ($idxRead >= count($q)) {
                break;
            }
            [$x, $y] = $q[$idxRead];
            ++$idxRead;
            foreach (self::DELTA_XY as [$dx, $dy]) {
                $x1 = $x + $dx;
                $y1 = $y + $dy;
                // also allow to traverse on extra border to make sure all outside blocks are reachable
                if (($x1 < $minX - 1) or ($x1 > $maxX + 1) or ($y1 < $minY - 1) or ($y1 > $maxY + 1)) {
                    continue;
                }
                $hash = $x1 . ' ' . $y1;
                if (isset($edgeBlocks[$hash]) or isset($outsideBlocks[$hash])) {
                    continue;
                }
                $outsideBlocks[$hash] = true;
                $q[] = [$x1, $y1];
            }
        }
        $ans1 = ($maxX - $minX + 3) * ($maxY - $minY + 3) - count($outsideBlocks);
        // @phpstan-ignore if.alwaysFalse
        if (self::DEBUG) {
            // @codeCoverageIgnoreStart
            echo PHP_EOL;
            for ($y = $minY; $y <= $maxY; ++$y) {
                $line = str_repeat('.', $maxX - $minX + 1);
                for ($x = $minX; $x <= $maxX; ++$x) {
                    $hash = $x . ' ' . $y;
                    if (isset($edgeBlocks[$hash])) {
                        $line[$x - $minX] = '#';
                    } elseif (!isset($outsideBlocks[$hash])) {
                        $line[$x - $minX] = '+';
                    }
                }
                echo $line, PHP_EOL;
            }
            // @codeCoverageIgnoreEnd
        }
        // ---------- Part 2
        // find all x and y junction positions, also include +1 values to help in area calculations
        $minX = 0;
        $minY = 0;
        $x = 0;
        $y = 0;
        $xPositions = [$x => true];
        $yPositions = [$y => true];
        for ($i = 0; $i < $maxCommands; ++$i) {
            [$dx, $dy] = self::DELTA_XY[$directionsPart2[$i]];
            $x += $dx * $stepsPart2[$i];
            $y += $dy * $stepsPart2[$i];
            $xPositions[$x] = true;
            $xPositions[$x + 1] = true;
            $yPositions[$y] = true;
            $yPositions[$y + 1] = true;
            $minX = intval(min($x, $minX));
            $minY = intval(min($y, $minY));
        }
        $xPositions[$minX - 1] = true;
        $yPositions[$minY - 1] = true;
        ksort($xPositions);
        ksort($yPositions);
        $idx2x = array_keys($xPositions);
        $idx2y = array_keys($yPositions);
        $x2idx = array_flip($idx2x);
        $y2idx = array_flip($idx2y);
        // traverse loop, fill out edgeBlock[] with position indices
        $idxX = $x2idx[0];
        $idxY = $y2idx[0];
        $hash = $idxX . ' ' . $idxY;
        $edgeBlocks = [$hash => true];
        for ($i = 0; $i < $maxCommands; ++$i) {
            $x = $idx2x[$idxX];
            $y = $idx2y[$idxY];
            [$dx, $dy] = self::DELTA_XY[$directionsPart2[$i]];
            $toX = $x + $dx * $stepsPart2[$i];
            $toY = $y + $dy * $stepsPart2[$i];
            $toIdxX = $x2idx[$toX];
            $toIdxY = $y2idx[$toY];
            if ($directionsPart2[$i] == 'R') {
                for ($j = $idxX; $j <= $toIdxX; ++$j) {
                    $hash = $j . ' ' . $idxY;
                    $edgeBlocks[$hash] = true;
                }
            } elseif ($directionsPart2[$i] == 'L') {
                for ($j = $idxX; $j >= $toIdxX; --$j) {
                    $hash = $j . ' ' . $idxY;
                    $edgeBlocks[$hash] = true;
                }
            } elseif ($directionsPart2[$i] == 'D') {
                for ($j = $idxY; $j <= $toIdxY; ++$j) {
                    $hash = $idxX . ' ' . $j;
                    $edgeBlocks[$hash] = true;
                }
            } elseif ($directionsPart2[$i] == 'U') {
                for ($j = $idxY; $j >= $toIdxY; --$j) {
                    $hash = $idxX . ' ' . $j;
                    $edgeBlocks[$hash] = true;
                }
            }
            $idxX = $toIdxX;
            $idxY = $toIdxY;
        }
        // BFS from corner using position indices, fill out outsideBlocks[]
        $idxX = 0;
        $idxY = 0;
        $hash = $idxX . ' ' . $idxY;
        $outsideBlocks = [$hash => [$idxX, $idxY]];
        $q = [[$idxX, $idxY]];
        $idxRead = 0;
        while (true) {
            if ($idxRead >= count($q)) {
                break;
            }
            [$idxX, $idxY] = $q[$idxRead];
            ++$idxRead;
            foreach (self::DELTA_XY as [$dx, $dy]) {
                $x1 = $idxX + $dx;
                $y1 = $idxY + $dy;
                if (($x1 < 0) or ($x1 >= count($idx2x)) or ($y1 < 0) or ($y1 >= count($idx2y))) {
                    continue;
                }
                $hash = $x1 . ' ' . $y1;
                if (isset($edgeBlocks[$hash]) or isset($outsideBlocks[$hash])) {
                    continue;
                }
                $outsideBlocks[$hash] = [$x1, $y1];
                $q[] = [$x1, $y1];
            }
        }
        // calculate remaining area after deducting area of outsideBlocks[]
        $ans2 = ($idx2x[count($idx2x) - 1] - $idx2x[0] + 1) * ($idx2y[count($idx2y) - 1] - $idx2y[0] + 1);
        foreach ($outsideBlocks as [$idxX, $idxY]) {
            $ans2 -= (($idx2x[$idxX + 1] ?? ($idx2x[$idxX] + 1)) - $idx2x[$idxX])
                * (($idx2y[$idxY + 1] ?? ($idx2y[$idxY] + 1)) - $idx2y[$idxY]);
        }
        return [strval($ans1), strval($ans2)];
    }
}
