<?php

declare(strict_types=1);

namespace TBali\Aoc2016;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2016 Day 16: Dragon Checksum.
 *
 * Part 1: Using the initial state in your puzzle input, what is the correct checksum?
 * Part 2: Again using the initial state in your puzzle input, what is the correct checksum for this disk?
 *
 * @see https://adventofcode.com/2016/day/16
 */
final class Aoc2016Day16 extends SolutionBase
{
    public const YEAR = 2016;
    public const DAY = 16;
    public const TITLE = 'Dragon Checksum';
    public const SOLUTIONS = ['00100111000101111', '11101110011100110'];
    public const STRING_INPUT = '01111010110010011';
    public const EXAMPLE_SOLUTIONS = [['01100', 0], [0, 0]];
    public const EXAMPLE_STRING_INPUTS = ['10000', ''];

    private const EXAMPLE_LEN = 20;
    private const PART1_LEN = 272;
    private const PART2_LEN = 35651584;

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
        $data = $input[0] ?? '';
        $len1 = ($data == self::STRING_INPUT ? self::PART1_LEN : self::EXAMPLE_LEN);
        $ans1 = $this->solvePart($data, $len1);
        if ($len1 != self::PART1_LEN) {
            return [$ans1, '0'];
        }
        $len2 = self::PART2_LEN;
        $ans2 = $this->solvePart($data, $len2);
        return [$ans1, $ans2];
    }

    private function solvePart(string $data, int $len): string
    {
        while (strlen($data) < $len) {
            $data .= '0' . strtr(strrev($data), '01', '10');
        }
        $data = substr($data, 0, $len);
        while (strlen($data) % 2 == 0) {
            $data = implode('', array_map(
                fn (string $x): string => ['00' => '1', '11' => '1', '01' => '0', '10' => '0'][$x] ?? '',
                str_split($data, 2)
            ));
        }
        return $data;
    }
}
