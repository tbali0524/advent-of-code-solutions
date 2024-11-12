<?php

declare(strict_types=1);

namespace TBali\Aoc2022;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2022 Day 6: Tuning Trouble.
 *
 * Part 1: How many characters need to be processed before the first start-of-packet marker is detected?
 * Part 2: How many characters need to be processed before the first start-of-message marker is detected?
 *
 * @see https://adventofcode.com/2022/day/6
 */
final class Aoc2022Day06 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 6;
    public const TITLE = 'Tuning Trouble';
    public const SOLUTIONS = [1855, 3256];
    public const EXAMPLE_SOLUTIONS = [[7, 19], [11, 26]];

    private const MARKER_WIDTH_PART1 = 4;
    private const MARKER_WIDTH_PART2 = 14;

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
        $data = $input[0] ?: '0';
        // ---------- Part 1 + 2
        $ans1 = $this->solvePart($data, self::MARKER_WIDTH_PART1);
        $ans2 = $this->solvePart($data, self::MARKER_WIDTH_PART2);
        return [strval($ans1), strval($ans2)];
    }

    private function solvePart(string $data, int $markerWidth): int
    {
        for ($i = $markerWidth; $i <= strlen($data); ++$i) {
            $cand = substr($data, $i - $markerWidth, $markerWidth);
            // count_chars mode = 3: a string containing all unique characters is returned.
            if (strlen(count_chars($cand, 3)) == $markerWidth) {
                return $i;
            }
        }
        // @codeCoverageIgnoreStart
        throw new \Exception('No solution found');
        // @codeCoverageIgnoreEnd
    }
}
