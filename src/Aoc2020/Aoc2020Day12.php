<?php

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2020 Day 12: Rain Risk.
 *
 * Part 1: What is the Manhattan distance between that location and the ship's starting position?
 * Part 2: Almost all of the actions indicate how to move a waypoint which is relative to the ship's position.
 *         What is the Manhattan distance between that location and the ship's starting position?
 *
 * Topics: walk simulation
 *
 * @see https://adventofcode.com/2020/day/12
 */
final class Aoc2020Day12 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 12;
    public const TITLE = 'Rain Risk';
    public const SOLUTIONS = [1710, 62045];
    public const EXAMPLE_SOLUTIONS = [[25, 286]];

    private const DELTAS = [[0, 1], [1, 0], [0, -1], [-1, 0]];
    private const TURNS = ['R' => 1, 'L' => -1];
    private const DIRECTIONS = ['N' => 0, 'E' => 1, 'S' => 2, 'W' => 3];

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
        [$x, $y] = [0, 0];
        $heading = self::DIRECTIONS['E'];
        foreach ($input as $line) {
            $command = $line[0];
            $param = intval(substr($line, 1));
            if (isset(self::TURNS[$command])) {
                $heading = ($heading + self::TURNS[$command] * intdiv($param, 90)) % 4;
                $heading = ($heading + 4) % 4;
                continue;
            }
            [$dx, $dy] = (
                $command == 'F'
                ? self::DELTAS[$heading]
                : self::DELTAS[self::DIRECTIONS[$command] ?? 0]
            );
            $x += $dx * $param;
            $y += $dy * $param;
        }
        $ans1 = abs($x) + abs($y);
        // ---------- Part 2
        [$x, $y] = [0, 0];
        [$wx, $wy] = [10, 1];
        foreach ($input as $line) {
            $command = $line[0];
            $param = intval(substr($line, 1));
            if (isset(self::TURNS[$command])) {
                $turn = (4 + self::TURNS[$command] * intdiv($param, 90)) % 4;
                [$wx, $wy] = match ($turn) {
                    // @codeCoverageIgnoreStart
                    0 => [$wx, $wy],
                    // @codeCoverageIgnoreEnd
                    1, -3 => [$wy, -$wx],
                    2, -2 => [-$wx, -$wy],
                    3, -1 => [-$wy, $wx],
                };
                continue;
            }
            if ($command == 'F') {
                $x += $wx * $param;
                $y += $wy * $param;
                continue;
            }
            [$dx, $dy] = self::DELTAS[self::DIRECTIONS[$command]];
            $wx += $dx * $param;
            $wy += $dy * $param;
        }
        $ans2 = abs($x) + abs($y);
        return [strval($ans1), strval($ans2)];
    }
}
