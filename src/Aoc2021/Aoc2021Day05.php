<?php

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 5: Hydrothermal Venture.
 *
 * Part 1: At how many points do at least two lines overlap?
 * Part 2: Consider all of the lines. At how many points do at least two lines overlap?
 *
 * @see https://adventofcode.com/2021/day/5
 */
final class Aoc2021Day05 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 5;
    public const TITLE = 'Hydrothermal Venture';
    public const SOLUTIONS = [6841, 19258];
    public const EXAMPLE_SOLUTIONS = [[5, 12]];

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
        // ---------- Part 1 + 2
        $visitedPart1 = [];
        $visitedPart2 = [];
        foreach ($input as $line) {
            $count = sscanf($line, '%d,%d -> %d,%d', $fromX, $fromY, $toX, $toY);
            /** @var int $fromX */
            /** @var int $fromY */
            /** @var int $toX */
            /** @var int $toY */
            if ($count != 4) {
                throw new \Exception('Invalid input');
            }
            $dx = ($toX <=> $fromX);
            $dy = ($toY <=> $fromY);
            $steps = intval(max(abs($toX - $fromX), abs($toY - $fromY)));
            $x = $fromX;
            $y = $fromY;
            for ($i = 0; $i <= $steps; ++$i) {
                $hash = $x . ',' . $y;
                if (($dx == 0) or ($dy == 0)) {
                    $visitedPart1[$hash] = ($visitedPart1[$hash] ?? 0) + 1;
                }
                $visitedPart2[$hash] = ($visitedPart2[$hash] ?? 0) + 1;
                $x += $dx;
                $y += $dy;
            }
        }
        $ans1 = count(array_filter($visitedPart1, fn (int $x): bool => $x > 1));
        $ans2 = count(array_filter($visitedPart2, fn (int $x): bool => $x > 1));
        return [strval($ans1), strval($ans2)];
    }
}
