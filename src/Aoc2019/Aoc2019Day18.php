<?php

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 18: Many-Worlds Interpretation.
 *
 * Part 1: How many steps is the shortest path that collects all of the keys?
 * Part 2: After updating your map and using the remote-controlled robots,
 *         what is the fewest steps necessary to collect all of the keys?
 *
 * Topics: BFS
 *
 * @see https://adventofcode.com/2019/day/18
 *
 * @todo complete part 2, fix memory overflow, speed-up
 */
final class Aoc2019Day18 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 18;
    public const TITLE = 'Many-Worlds Interpretation';
    public const SOLUTIONS = [5858, 0];
    public const EXAMPLE_SOLUTIONS = [[8, 0], [86, 0], [132, 0], [136, 0], [81, 0], [0, 8], [0, 24], [0, 32], [0, 72]];

    private const DEBUG = false;

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
        $grid = $input;
        $maxY = count($input);
        $maxX = strlen($input[0]);
        $maxKeys = 0;
        $startX = -1;
        $startY = 0;
        for ($y = 0; $y < $maxY; ++$y) {
            for ($x = 0; $x < $maxX; ++$x) {
                $c = $grid[$y][$x];
                if ($c == '@') {
                    $startX = $x;
                    $startY = $y;
                    continue;
                }
                if (($c >= 'a') and ($c <= 'z')) {
                    $key = ord($c) - ord('a');
                    if ($key >= $maxKeys) {
                        $maxKeys = $key + 1;
                    }
                }
            }
        }
        if (($startX < 0) or ($maxKeys == 0)) {
            throw new \Exception('Invalid input');
        }
        $pattern = substr($grid[$startY - 1], $startX - 1, 3)
            . substr($grid[$startY], $startX - 1, 3)
            . substr($grid[$startY + 1], $startX - 1, 3);
        $patternOk = $pattern == '....@....';
        // ---------- Part 1
        $ans1 = 0;
        if (!$patternOk or ($maxX >= 80)) {
            $robotHash = ($startY << 8) | $startX;
            $keys = 0;
            $maxRobots = 1;
            $ans1 = $this->solvePart($grid, $maxKeys, $robotHash, $keys, $maxRobots);
        }
        // @phpstan-ignore-next-line
        if (self::DEBUG) {
            // @codeCoverageIgnoreStart
            echo '-- ', $maxX . ' x ' . $maxY . ', k = ' . $maxKeys, PHP_EOL;
            echo '1: ', $ans1, PHP_EOL;
            // @codeCoverageIgnoreEnd
        }
        if (!$patternOk) {
            return [strval($ans1), '0'];
        }
        // ---------- Part 2
        $grid[$startY - 1][$startX - 1] = '@';
        $grid[$startY - 1][$startX] = '#';
        $grid[$startY - 1][$startX + 1] = '@';
        $grid[$startY][$startX - 1] = '#';
        $grid[$startY][$startX] = '#';
        $grid[$startY][$startX + 1] = '#';
        $grid[$startY + 1][$startX - 1] = '@';
        $grid[$startY + 1][$startX] = '#';
        $grid[$startY + 1][$startX + 1] = '@';
        $robotHash = ((($startY - 1) << 8) | ($startX - 1))
            | (((($startY - 1) << 8) | ($startX + 1)) << 16)
            | (((($startY + 1) << 8) | ($startX - 1)) << 32)
            | (((($startY + 1) << 8) | ($startX + 1)) << 48);
        $keys = 0;
        $maxRobots = 4;
        $ans2 = $this->solvePart($grid, $maxKeys, $robotHash, $keys, $maxRobots);
        // @phpstan-ignore-next-line
        if (self::DEBUG) {
            // @codeCoverageIgnoreStart
            echo '2: ', $ans2, PHP_EOL;
            // @codeCoverageIgnoreEnd
        }
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, string> $grid
     */
    private function solvePart(array $grid, int $maxKeys, int $robotHash, int $keys = 0, int $maxRobots = 4): int
    {
        $targetKeys = (1 << $maxKeys) - 1;
        $visited = [];
        $visited[$keys][$robotHash] = true;
        $q = [[$robotHash, $keys, 0]];
        $readIdx = 0;
        while (true) {
            if (count($q) <= $readIdx) {
                // @codeCoverageIgnoreStart
                throw new \Exception('No solution found');
                // @codeCoverageIgnoreEnd
            }
            [$robotHash, $keys, $steps] = $q[$readIdx];
            // if (count($q) == 0) {
            //     // @codeCoverageIgnoreStart
            //     throw new \Exception('No solution found');
            //     // @codeCoverageIgnoreEnd
            // }
            // [$robotHash, $keys, $steps] = array_shift($q);
            ++$readIdx;
            if ($keys == $targetKeys) {
                return $steps;
            }
            // @phpstan-ignore-next-line
            if (self::DEBUG) {
                // @codeCoverageIgnoreStart
                $robots = '(' . (($robotHash >> (16 * 0)) & 0xFFFF & 0xFF)
                    . ', ' . (((($robotHash >> (16 * 0)) & 0xFFFF) >> 8) & 0xFF) . ') '
                    . '(' . (($robotHash >> (16 * 1)) & 0xFFFF & 0xFF)
                    . ', ' . (((($robotHash >> (16 * 1)) & 0xFFFF) >> 8) & 0xFF) . ') '
                    . '(' . (($robotHash >> (16 * 2)) & 0xFFFF & 0xFF)
                    . ', ' . (((($robotHash >> (16 * 2)) & 0xFFFF) >> 8) & 0xFF) . ') '
                    . '(' . (($robotHash >> (16 * 3)) & 0xFFFF & 0xFF)
                    . ', ' . (((($robotHash >> (16 * 3)) & 0xFFFF) >> 8) & 0xFF) . ') ';
                echo 'S=' . $steps . ' k= ' . $keys . '; R: ' . $robots, PHP_EOL;
                // @codeCoverageIgnoreEnd
            }
            for ($idxRobot = 0; $idxRobot < $maxRobots; ++$idxRobot) {
                $xy = ($robotHash >> (16 * $idxRobot)) & 0xFFFF;
                $x = $xy & 0xFF;
                $y = ($xy >> 8) & 0xFF;
                foreach ([[0, -1], [0, 1], [-1, 0], [1, 0]] as [$dx, $dy]) {
                    $x1 = $x + $dx;
                    $y1 = $y + $dy;
                    $keys1 = $keys;
                    $c = $grid[$y1][$x1] ?? '#';
                    if ($c == '#') {
                        continue;
                    }
                    if (($c >= 'a') and ($c <= 'z')) {
                        $keys1 |= 1 << (ord($c) - ord('a'));
                    } elseif (($c >= 'A') and ($c <= 'Z')) {
                        if (($keys & (1 << (ord($c) - ord('A')))) == 0) {
                            continue;
                        }
                    }
                    $robotHash1 = $robotHash & ~(0xFFFF << (16 * $idxRobot));
                    $robotHash1 |= (($y1 << 8) | $x1) << (16 * $idxRobot);
                    if (isset($visited[$keys1][$robotHash1])) {
                        continue;
                    }
                    // @phpstan-ignore-next-line
                    if (self::DEBUG) {
                        // @codeCoverageIgnoreStart
                        $robots1 = '  #' . $idxRobot . '-> (' . $x1 . ',' . $y1 . '), k=' . $keys1;
                        echo $robots1, PHP_EOL;
                        // @codeCoverageIgnoreEnd
                    }
                    $visited[$keys1][$robotHash1] = true;
                    $q[] = [$robotHash1, $keys1, $steps + 1];
                }
            }
        }
    }
}
