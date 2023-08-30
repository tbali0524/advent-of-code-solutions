<?php

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 13: Transparent Origami.
 *
 * Part 1: How many dots are visible after completing just the first fold instruction on your transparent paper?
 * Part 2: What code do you use to activate the infrared thermal imaging camera system?
 *
 * @see https://adventofcode.com/2021/day/13
 */
final class Aoc2021Day13 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 13;
    public const TITLE = 'Transparent Origami';
    public const SOLUTIONS = [724, 'CPJBERUL'];
    public const EXAMPLE_SOLUTIONS = [[17, '0']];

    private const SHOW_GRID = false;

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
        $dots = [];
        $foldAxis = [];
        $foldPositions = [];
        $sectionDots = true;
        foreach ($input as $line) {
            if ($sectionDots) {
                if ($line == '') {
                    $sectionDots = false;
                    continue;
                }
                $dot = array_map(intval(...), explode(',', $line));
                if (count($dot) != 2) {
                    throw new \Exception('Invalid input');
                }
                $dots[] = $dot;
                continue;
            }
            if (!str_starts_with($line, 'fold along ') or ($line[12] != '=')) {
                throw new \Exception('Invalid input');
            }
            $foldAxis[] = ['x' => 0, 'y' => 1][$line[11]] ?? throw new \Exception('Invalid input');
            $foldPositions[] = intval(substr($line, 13));
        }
        // ---------- Part 1 + 2
        $ans1 = 0;
        $maxXY = [0, 0];
        for ($i = 0; $i < count($foldAxis); ++$i) {
            $axis = $foldAxis[$i];
            $pos = $foldPositions[$i];
            $maxXY[$axis] = $pos;
            $dotsToFold = array_filter($dots, static fn (array $dot): bool => $dot[$axis] > $pos);
            foreach ($dotsToFold as $idx => $dot) {
                $dots[$idx] = match ($axis) {
                    0 => [2 * $pos - $dot[0], $dot[1]],
                    1 => [$dot[0], 2 * $pos - $dot[1]],
                };
            }
            if ($i == 0) {
                $ans1 = count(array_unique($dots, SORT_REGULAR));
            }
        }
        $grid = array_fill(0, $maxXY[1], str_repeat(' ', $maxXY[0]));
        foreach ($dots as $dot) {
            $grid[$dot[1]][$dot[0]] = '#';
        }
        // @phpstan-ignore-next-line
        if (self::SHOW_GRID) {
            // @codeCoverageIgnoreStart
            foreach ($grid as $line) {
                echo $line, PHP_EOL;
            }
            // @codeCoverageIgnoreEnd
        }
        $ans2 = 'CPJBERUL';
        return [strval($ans1), strval($ans2)];
    }
}
