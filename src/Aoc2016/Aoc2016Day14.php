<?php

declare(strict_types=1);

namespace TBali\Aoc2016;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2016 Day 14: One-Time Pad.
 *
 * Part 1: Given the actual salt in your puzzle input, what index produces your 64th one-time pad key?
 * Part 2: Given the actual salt in your puzzle input and using 2016 extra MD5 calls of key stretching,
 *         what index now produces your 64th one-time pad key?
 *
 * @see https://adventofcode.com/2016/day/14
 *
 * @codeCoverageIgnore
 */
final class Aoc2016Day14 extends SolutionBase
{
    public const YEAR = 2016;
    public const DAY = 14;
    public const TITLE = 'One-Time Pad';
    public const SOLUTIONS = [25427, 22045];
    public const STRING_INPUT = 'yjdafjpo';
    public const EXAMPLE_SOLUTIONS = [[22728, 22551], [0, 0]];
    public const EXAMPLE_STRING_INPUTS = ['abc', ''];

    private const MAX_DISTANCE = 1000;
    private const MAX_KEY = 64;
    private const REPEAT_PART2 = 2016;
    /** @var string */
    private const HEX_DIGITS = '0123456789abcdef';

    /** @var array<int, string> */
    private array $hashes = [];
    /** @var array<string, int> */
    private array $lastSeenFive = [];

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
        $salt = $input[0] ?? '';
        // ---------- Part 1 + 2
        $ans1 = $this->solvePart($salt);
        $ans2 = $this->solvePart($salt, self::REPEAT_PART2);
        return [strval($ans1), strval($ans2)];
    }

    private function solvePart(string $salt, int $repeat = 0): int
    {
        $this->hashes = array_fill(0, self::MAX_DISTANCE, '');
        for ($i = 0; $i < self::MAX_DISTANCE; ++$i) {
            $hash = $salt . strval($i);
            for ($j = 0; $j <= $repeat; ++$j) {
                $hash = md5($hash);
            }
            $this->hashes[$i] = $hash;
        }
        $this->lastSeenFive = [];
        for ($j = 0; $j < strlen(self::HEX_DIGITS); ++$j) {
            $digit = self::HEX_DIGITS[$j];
            $this->lastSeenFive[$digit] = -1;
            $needle = str_repeat($digit, 5);
            for ($i = count($this->hashes) - 1; $i >= 0; --$i) {
                if (str_contains($this->hashes[$i], $needle)) {
                    $this->lastSeenFive[$digit] = $i;
                    break;
                }
            }
        }
        $count = 0;
        $idx = 0;
        while (true) {
            $hash = $salt . strval($idx + self::MAX_DISTANCE);
            for ($j = 0; $j <= $repeat; ++$j) {
                $hash = md5($hash);
            }
            $this->hashes[$idx + self::MAX_DISTANCE] = $hash;
            for ($j = 0; $j < strlen(self::HEX_DIGITS); ++$j) {
                $digit = self::HEX_DIGITS[$j];
                if (str_contains($hash, str_repeat($digit, 5))) {
                    $this->lastSeenFive[$digit] = $idx + self::MAX_DISTANCE;
                }
            }
            $hash = $this->hashes[$idx] ?? '';
            for ($i = 2; $i < strlen($hash); ++$i) {
                if (($hash[$i] != $hash[$i - 1]) or ($hash[$i] != $hash[$i - 2])) {
                    continue;
                }
                if (($this->lastSeenFive[$hash[$i]] ?? -1) > $idx) {
                    ++$count;
                    if ($count == self::MAX_KEY) {
                        return $idx;
                    }
                }
                break;
            }
            // unset($this->hashes[$idx]);
            ++$idx;
        }
    }
}
