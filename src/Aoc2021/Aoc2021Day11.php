<?php

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 11: Dumbo Octopus.
 *
 * Part 1: How many total flashes are there after 100 steps?
 * Part 2: What is the first step during which all octopuses flash?
 *
 * Topics: walk simulation
 *
 * @see https://adventofcode.com/2021/day/11
 */
final class Aoc2021Day11 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 11;
    public const TITLE = 'Dumbo Octopus';
    public const SOLUTIONS = [1747, 505];
    public const EXAMPLE_SOLUTIONS = [[1656, 195]];

    private const SIZE = 10;
    private const MAX_STEPS_PART1 = 100;

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
        $startEnergies = array_map(intval(...), str_split(implode('', $input)));
        if (count($startEnergies) != self::SIZE ** 2) {
            throw new \Exception('Invalid input');
        }
        // ---------- Part 1 + 2
        $ans1 = -1;
        $ans2 = -1;
        $energies = $startEnergies;
        $countFlashes = 0;
        $step = 0;
        while (true) {
            ++$step;
            $energies = array_map(static fn (int $x) => $x + 1, $energies);
            $flashQueue = array_keys($energies, 10, true);
            $readIdx = 0;
            $flashed = [];
            foreach ($flashQueue as $pos) {
                $flashed[$pos] = true;
            }
            while ($readIdx < count($flashQueue)) {
                $pos = $flashQueue[$readIdx];
                ++$readIdx;
                $x = $pos % self::SIZE;
                $y = intdiv($pos, self::SIZE);
                for ($dy = -1; $dy <= 1; ++$dy) {
                    $y1 = $y + $dy;
                    if (($y1 < 0) or ($y1 >= self::SIZE)) {
                        continue;
                    }
                    for ($dx = -1; $dx <= 1; ++$dx) {
                        if (($dx == 0) and ($dy == 0)) {
                            continue;
                        }
                        $x1 = $x + $dx;
                        if (($x1 < 0) or ($x1 >= self::SIZE)) {
                            continue;
                        }
                        $pos1 = $y1 * self::SIZE + $x1;
                        if (isset($flashed[$pos1])) {
                            continue;
                        }
                        ++$energies[$pos1];
                        if ($energies[$pos1] <= 9) {
                            continue;
                        }
                        $flashed[$pos1] = true;
                        $flashQueue[] = $pos1;
                    }
                }
            }
            $countFlashes += count($flashed);
            foreach (array_keys($flashed) as $pos) {
                $energies[$pos] = 0;
            }
            if ($step == self::MAX_STEPS_PART1) {
                $ans1 = $countFlashes;
            }
            if (($ans2 < 0) and (count($flashed) == self::SIZE ** 2)) {
                $ans2 = $step;
            }
            if (($ans1 >= 0) and ($ans2 >= 0)) {
                break;
            }
            if ($step == 1000) {
                break;
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}
