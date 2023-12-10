<?php

declare(strict_types=1);

namespace TBali\Aoc2023;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2023 Day 10: Pipe Maze.
 *
 * Part 1: How many steps along the loop does it take to get from the starting position
 *         to the point farthest from the starting position?
 * Part 2: How many tiles are enclosed by the loop?
 *
 * @see https://adventofcode.com/2023/day/10
 */
final class Aoc2023Day10 extends SolutionBase
{
    public const YEAR = 2023;
    public const DAY = 10;
    public const TITLE = 'Pipe Maze';
    public const SOLUTIONS = [6820, 0];
    public const EXAMPLE_SOLUTIONS = [[4, 1], [8, 1], [0, 4], [0, 4], [0, 8], [0, 10]];

    private const DEBUG = false;
    private const EMPTY = '.';
    private const DIR_NAMES = 'ESWN'; // must be in clockwise order!
    private const DIR_DELTAS = [
        'W' => [-1, 0],
        'S' => [0, 1],
        'E' => [1, 0],
        'N' => [0, -1],
    ];
    private const CORNERS = [
        'EN' => [1, 1],
    ];
    private const NEIGHBOURS = [
        'F' => ['E', 'S'],
        '-' => ['E', 'W'],
        '7' => ['S', 'W'],
        '|' => ['S', 'N'],
        'J' => ['W', 'N'],
        'L' => ['N', 'E'],
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
        $maxY = count($input);
        $maxX = strlen($input[0] ?? '');
        $grid = $input;
        $startX = -1;
        $startY = -1;
        for ($y = 0; $y < $maxY; ++$y) {
            for ($x = 0; $x < $maxX; ++$x) {
                $c = $grid[$y][$x];
                if ($c == 'S') {
                    $startX = $x;
                    $startY = $y;
                    continue;
                }
                if (($c != self::EMPTY) and !isset(self::NEIGHBOURS[$c])) {
                    throw new \Exception('Invalid input');
                }
            }
        }
        if ($startX < 0) {
            throw new \Exception('Invalid input');
        }
        // ---------- Find pipe type at start position
        foreach (self::NEIGHBOURS as $c => $nbList) {
            $isOk = true;
            foreach ($nbList as $nbDir) {
                [$dx, $dy] = self::DIR_DELTAS[$nbDir];
                $nbX = $startX + $dx;
                $nbY = $startY + $dy;
                if (($nbX < 0) or ($nbX >= $maxX) or ($nbY < 0) or ($nbY >= $maxY)) {
                    $isOk = false;
                    break;
                }
                $nbC = $grid[$nbY][$nbX];
                $isNbOk = false;
                foreach ((self::NEIGHBOURS[$nbC] ?? []) as $nbnbDir) {
                    [$nbDx, $nbDy] = self::DIR_DELTAS[$nbnbDir];
                    if (($nbDx == -$dx) and ($nbDy == -$dy)) {
                        $isNbOk = true;
                        break;
                    }
                }
                if (!$isNbOk) {
                    $isOk = false;
                    break;
                }
            }
            if ($isOk) {
                $grid[$startY][$startX] = $c;
                break;
            }
        }
        if ($grid[$startY][$startX] == 'S') {
            throw new \Exception('Invalid input');
        }
        // ---------- Part 1, with some preparation (fill sideTiles) to Part 2
        $maxStep = 0;
        $isPipe = [];
        $sideTiles = [[], []];
        $step = 0;
        $x = $startX;
        $y = $startY;
        $dir = self::NEIGHBOURS[$grid[$y][$x]][0];
        while (true) {
            ++$step;
            if ($step > $maxStep) {
                $maxStep = $step;
            }
            $c = $grid[$y][$x];
            foreach (self::NEIGHBOURS[$c] as $nbDir) {
                [$dx, $dy] = self::DIR_DELTAS[$nbDir];
                $nbX = $x + $dx;
                $nbY = $y + $dy;
                if (($nbX < 0) or ($nbX >= $maxX) or ($nbY < 0) or ($nbY >= $maxY)) {
                    throw new \Exception('Invalid input');
                }
                if (($step <= 2) and ($nbX == $startX) and ($nbY == $startY)) {
                    continue;
                }
                if (isset($isPipe[$nbY][$nbX])) {
                    continue;
                }
                $x = $nbX;
                $y = $nbY;
                $isPipe[$y][$x] = true;
                // track tiles on both sides before and after turning
                $dirs = [$nbDir];
                foreach ($dirs as $dirToCheck) {
                    $idxDir = strpos(self::DIR_NAMES, $dirToCheck) ?: 0;
                    for ($dDir = -1; $dDir <= 1; $dDir += 2) {
                        $sideDir = self::DIR_NAMES[($idxDir + $dDir + 4) % 4];
                        [$sideDx, $sideDy] = self::DIR_DELTAS[$sideDir];
                        $sideX = $nbX + $sideDx;
                        $sideY = $nbY + $sideDy;
                        if (($sideX < 0) or ($sideX >= $maxX) or ($sideY < 0) or ($sideY >= $maxY)) {
                            continue;
                        }
                        $sideTiles[$dDir == 1 ? 1 : 0][] = [$sideX, $sideY];
                    }
                }
                $dir = $nbDir;
                if (($x == $startX) and ($y == $startY)) {
                    break 2;
                }
                break;
            }
        }
        $ans1 = intval(ceil($maxStep / 2));
        // ---------- Part 2
        $ans2 = 0;
        $coverGrid = $grid;
        for ($y = 0; $y < $maxY; ++$y) {
            for ($x = 0; $x < $maxX; ++$x) {
                if (!isset($isPipe[$y][$x])) {
                    $coverGrid[$y][$x] = self::EMPTY;
                }
            }
        }
        $q = [[], []];
        foreach ($sideTiles as $side => $tileList) {
            foreach ($tileList as [$x, $y]) {
                if (!isset($isPipe[$y][$x])) {
                    if ($coverGrid[$y][$x] == self::EMPTY) {
                        $coverGrid[$y][$x] = $side == 0 ? 'O' : 'x';
                        $q[$side][] = [$x, $y];
                    }
                }
            }
        }
        $countTiles = [0, 0];
        $idxOutside = 0;
        for ($side = 0; $side <= 1; ++$side) {
            $idxRead = 0;
            while (true) {
                if ($idxRead >= count($q[$side])) {
                    break;
                }
                [$x, $y] = $q[$side][$idxRead];
                ++$idxRead;
                ++$countTiles[$side];
                foreach (self::DIR_DELTAS as [$dx, $dy]) {
                    $x1 = $x + $dx;
                    $y1 = $y + $dy;
                    if (($x1 < 0) or ($x1 >= $maxX) or ($y1 < 0) or ($y1 >= $maxY)) {
                        $idxOutside = $side;
                        continue;
                    }
                    if ($coverGrid[$y1][$x1] != self::EMPTY) {
                        continue;
                    }
                    $coverGrid[$y1][$x1] = $side == 0 ? 'O' : 'x';
                    $q[$side][] = [$x1, $y1];
                }
            }
        }
        if (self::DEBUG) {
            echo '-- start: (' . $startX . ', ' . $startY . ')', PHP_EOL;
            echo implode(PHP_EOL, $grid), PHP_EOL, PHP_EOL;
            echo implode(PHP_EOL, $coverGrid), PHP_EOL, PHP_EOL, PHP_EOL;
        }
        $ans2 = $countTiles[1 - $idxOutside];
        for ($y = 0; $y < $maxY; ++$y) {
            for ($x = 0; $x < $maxX; ++$x) {
                if ($coverGrid[$y][$x] == self::EMPTY) {
                    ++$ans2;
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}
