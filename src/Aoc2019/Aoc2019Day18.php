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
    private const BITS_PER_POS = 8;
    private const BITS_PER_COORD = 2 * self::BITS_PER_POS;
    private const MASK_POS = (1 << self::BITS_PER_POS) - 1;
    private const MASK_COORD = (1 << self::BITS_PER_COORD) - 1;

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
            $robotHash = ($startY << self::BITS_PER_POS) | $startX;
            $keys = 0;
            $maxRobots = 1;
            $ans1 = $this->solvePart($grid, $maxKeys, $robotHash, $keys, $maxRobots);
        }
        // @phpstan-ignore-next-line
        if (self::DEBUG) {
            // @codeCoverageIgnoreStart
            echo '------ ', $maxX . ' x ' . $maxY . ', k = ' . $maxKeys, PHP_EOL;
            echo '-- 1: ', $ans1, PHP_EOL;
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
        $robotHash = ((($startY - 1) << self::BITS_PER_POS) | ($startX - 1))
            | (((($startY - 1) << self::BITS_PER_POS) | ($startX + 1)) << (1 * self::BITS_PER_COORD))
            | (((($startY + 1) << self::BITS_PER_POS) | ($startX - 1)) << (2 * self::BITS_PER_COORD))
            | (((($startY + 1) << self::BITS_PER_POS) | ($startX + 1)) << (3 * self::BITS_PER_COORD));
        $keys = 0;
        $maxRobots = 4;
        // $ans2 = 0;
        $ans2 = $this->solvePart($grid, $maxKeys, $robotHash, $keys, $maxRobots);
        // @phpstan-ignore-next-line
        if (self::DEBUG) {
            // @codeCoverageIgnoreStart
            echo '-- 2: ', $ans2, PHP_EOL;
            // @codeCoverageIgnoreEnd
        }
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, string> $grid
     */
    private function solvePart(array $grid, int $maxKeys, int $robotHash, int $startKeys = 0, int $maxRobots = 4): int
    {
        $targetKeys = (1 << $maxKeys) - 1;
        $visited = [];
        $visited[$startKeys][$robotHash] = true;
        $q = [[$robotHash, $startKeys, 0]];
        $readIdx = 0;
        $prevSteps = 0;
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
                if (($maxRobots > 1) and ($steps > $prevSteps)) {
                    $prevSteps = $steps;
                    echo $steps, PHP_EOL;
                }
                // @codeCoverageIgnoreEnd
            }
            // @phpstan-ignore-next-line
            if (self::DEBUG) {
                // @codeCoverageIgnoreStart
                $robots = '(' . (($robotHash >> (0 * self::BITS_PER_COORD)) & self::MASK_POS)
                    . ', ' . (($robotHash >> (0 * self::BITS_PER_COORD + self::BITS_PER_POS)) & self::MASK_POS)
                    . ') (' . (($robotHash >> (1 * self::BITS_PER_COORD)) & self::MASK_POS)
                    . ', ' . (($robotHash >> (1 * self::BITS_PER_COORD + self::BITS_PER_POS)) & self::MASK_POS)
                    . ') (' . (($robotHash >> (2 * self::BITS_PER_COORD)) & self::MASK_POS)
                    . ', ' . (($robotHash >> (2 * self::BITS_PER_COORD + self::BITS_PER_POS)) & self::MASK_POS)
                    . ') (' . (($robotHash >> (3 * self::BITS_PER_COORD)) & self::MASK_POS)
                    . ', ' . (($robotHash >> (3 * self::BITS_PER_COORD + self::BITS_PER_POS)) & self::MASK_POS)
                    . ') ';
                // echo 'S=' . $steps . ' k= ' . $keys . '; R: ' . $robots, PHP_EOL;
                // @codeCoverageIgnoreEnd
            }
            for ($idxRobot = 0; $idxRobot < $maxRobots; ++$idxRobot) {
                $xy = ($robotHash >> ($idxRobot * self::BITS_PER_COORD)) & self::MASK_COORD;
                $x = $xy & self::MASK_POS;
                $y = ($xy >> self::BITS_PER_POS) & self::MASK_POS;
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
                    $robotHash1 = $robotHash & ~(self::MASK_COORD << ($idxRobot * self::BITS_PER_COORD));
                    $robotHash1 |= (($y1 << self::BITS_PER_POS) | $x1) << ($idxRobot * self::BITS_PER_COORD);
                    if (isset($visited[$keys1][$robotHash1])) {
                        continue;
                    }
                    // @phpstan-ignore-next-line
                    if (self::DEBUG) {
                        // @codeCoverageIgnoreStart
                        $robots1 = '  #' . $idxRobot . '-> (' . $x1 . ',' . $y1 . '), k=' . $keys1;
                        // echo $robots1, PHP_EOL;
                        // @codeCoverageIgnoreEnd
                    }
                    $visited[$keys1][$robotHash1] = true;
                    $q[] = [$robotHash1, $keys1, $steps + 1];
                }
            }
        }
    }
}
