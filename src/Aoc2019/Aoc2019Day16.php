<?php

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 16: Flawed Frequency Transmission.
 *
 * Part 1: After 100 phases of FFT, what are the first eight digits in the final output list?
 * Part 2: After repeating your input signal 10000 times and running 100 phases of FFT,
 *         what is the eight-digit message embedded in the final output list?
 *
 * @see https://adventofcode.com/2019/day/16
 */
final class Aoc2019Day16 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 16;
    public const TITLE = 'Flawed Frequency Transmission';
    public const SOLUTIONS = [30550349, 62938399];
    public const EXAMPLE_SOLUTIONS = [['24176176', 0], ['73745418', 0], ['52432133', 0]];

    private const MAX_PHASE_PART1 = 100;
    private const BASE_PATTERN = [0, 1, 0, -1];
    private const MAX_PHASE_PART2 = 100;
    private const REPEAT_PART2 = 10_000;

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
        $ans1 = 0;
        $data = $input[0];
        $pattern = [];
        for ($i = 0; $i < strlen($data); ++$i) {
            $pattern[$i] = array_fill(0, strlen($data), 0);
            $idx = -1;
            for ($j = 0; $j <= strlen($data); ++$j) {
                if ($j % ($i + 1) == 0) {
                    $idx = ($idx + 1) % count(self::BASE_PATTERN);
                }
                $pattern[$i][$j] = self::BASE_PATTERN[$idx];
            }
            $pattern[$i] = array_slice($pattern[$i], 1);
        }
        for ($phase = 0; $phase < self::MAX_PHASE_PART1; ++$phase) {
            $next = $data;
            for ($i = 0; $i < strlen($data); ++$i) {
                $sum = 0;
                for ($j = 0; $j < strlen($data); ++$j) {
                    $c = ord($data[$j]) - ord('0');
                    $sum += $c * $pattern[$i][$j % count($pattern[$i])];
                }
                $next[$i] = strval($sum)[-1];
            }
            $data = $next;
        }
        $ans1 = substr($data, 0, 8);
        // ---------- Part 2
        if (strlen($input[0]) == 32) {
            return [strval($ans1), '0'];
        }
        // @codeCoverageIgnoreStart
        $skip = intval(substr($input[0], 0, 7));
        $data = substr(str_repeat($input[0], self::REPEAT_PART2), $skip);
        for ($phase = 0; $phase < self::MAX_PHASE_PART2; ++$phase) {
            $sum = 0;
            for ($i = strlen($data) - 1; $i >= 0; --$i) {
                $sum += ord($data[$i]) - ord('0');
                $data[$i] = chr($sum % 10 + ord('0'));
            }
        }
        $ans2 = substr($data, 0, 8);
        return [strval($ans1), strval($ans2)];
        // @codeCoverageIgnoreEnd
    }
}
