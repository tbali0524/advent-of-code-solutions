<?php

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 10: Syntax Scoring.
 *
 * Part 1: What is the total syntax error score for those errors?
 * Part 2: Find the completion string for each incomplete line, score the completion strings, and sort the scores.
 *         What is the middle score?
 *
 * @see https://adventofcode.com/2021/day/10
 */
final class Aoc2021Day10 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 10;
    public const TITLE = 'Syntax Scoring';
    public const SOLUTIONS = [265527, 3969823589];
    public const EXAMPLE_SOLUTIONS = [[26397, 288957]];

    private const MATCHING_CLOSE = [
        '(' => ')',
        '[' => ']',
        '{' => '}',
        '<' => '>',
    ];
    private const SCORES_PART1 = [')' => 3, ']' => 57, '}' => 1197, '>' => 25137];
    private const SCORES_PART2 = [')' => 1, ']' => 2, '}' => 3, '>' => 4];

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
        $ans1 = 0;
        $scores = [];
        foreach ($input as $line) {
            $stack = [];
            $isCorrupted = false;
            foreach (str_split($line) as $c) {
                if (isset(self::MATCHING_CLOSE[$c])) {
                    $stack[] = $c;
                    continue;
                }
                if ((count($stack) == 0) or !isset(self::SCORES_PART1[$c])) {
                    throw new \Exception('invalid input');
                }
                $opening = array_pop($stack);
                if ($c != self::MATCHING_CLOSE[$opening]) {
                    $ans1 += self::SCORES_PART1[$c];
                    $isCorrupted = true;
                    break;
                }
            }
            if ($isCorrupted) {
                continue;
            }
            $score = 0;
            while (count($stack) > 0) {
                $opening = array_pop($stack);
                $score = $score * 5 + (self::SCORES_PART2[self::MATCHING_CLOSE[$opening]] ?? 0);
            }
            $scores[] = $score;
        }
        sort($scores);
        $ans2 = $scores[intdiv(count($scores), 2)];
        return [strval($ans1), strval($ans2)];
    }
}
