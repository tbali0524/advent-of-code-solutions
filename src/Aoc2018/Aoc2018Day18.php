<?php

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 18: Settlers of The North Pole.
 *
 * Part 1: What will the total resource value of the lumber collection area be after 10 minutes?
 * Part 2: What will the total resource value of the lumber collection area be after 1000000000 minutes?
 *
 * Topics: Conway's Game of Life, simulation, cycle detection
 *
 * @see https://adventofcode.com/2018/day/18
 */
final class Aoc2018Day18 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 18;
    public const TITLE = 'Settlers of The North Pole';
    public const SOLUTIONS = [536370, 190512];
    public const EXAMPLE_SOLUTIONS = [[1147, 0]];

    private const MAX_TURNS_PART1 = 10;
    private const MAX_TURNS_PART2 = 1_000_000_000;

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
        $maxY = count($input);
        $maxX = strlen($input[0] ?? '');
        $prev = implode('', $input);
        // ---------- Part 1 + 2
        $ans1 = 0;
        $ans2 = 0;
        $memo = [$prev => 0];
        $foundCycle = false;
        for ($turn = 0; $turn < self::MAX_TURNS_PART2; ++$turn) {
            $next = $prev;
            for ($y = 0; $y < $maxY; ++$y) {
                for ($x = 0; $x < $maxX; ++$x) {
                    $countTree = 0;
                    $countLumber = 0;
                    for ($dy = -1; $dy <= 1; ++$dy) {
                        for ($dx = -1; $dx <= 1; ++$dx) {
                            if (($dx == 0) and ($dy == 0)) {
                                continue;
                            }
                            $x1 = $x + $dx;
                            $y1 = $y + $dy;
                            if (($x1 < 0) or ($x1 >= $maxX) or ($y1 < 0) or ($y1 >= $maxY)) {
                                continue;
                            }
                            $pos1 = $y1 * $maxX + $x1;
                            if ($prev[$pos1] == '|') {
                                ++$countTree;
                            } elseif ($prev[$pos1] == '#') {
                                ++$countLumber;
                            }
                        }
                    }
                    $pos = $y * $maxX + $x;
                    $next[$pos] = match ($prev[$pos]) {
                        '.' => $countTree >= 3 ? '|' : '.',
                        '|' => $countLumber >= 3 ? '#' : '|',
                        '#' => $countTree >= 1 && $countLumber >= 1 ? '#' : '.',
                        default => throw new \Exception('Invalid input'),
                    };
                }
            }
            $prev = $next;
            if ($turn == self::MAX_TURNS_PART1 - 1) {
                $ans1 = substr_count($next, '|') * substr_count($next, '#');
            }
            if ($turn < self::MAX_TURNS_PART1 - 1) {
                continue;
            }
            if ($foundCycle) {
                continue;
            }
            if (!isset($memo[$next])) {
                $memo[$next] = $turn;
                continue;
            }
            $foundCycle = true;
            $cycleLen = $turn - $memo[$next];
            $cycleCount = intdiv(self::MAX_TURNS_PART2 - $turn - 1, $cycleLen);
            $turn += $cycleCount * $cycleLen;
        }
        $ans2 = substr_count($next, '|') * substr_count($next, '#');
        return [strval($ans1), strval($ans2)];
    }
}
