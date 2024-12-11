<?php

declare(strict_types=1);

namespace TBali\Aoc2024;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2024 Day 11: Plutonian Pebbles.
 *
 * @see https://adventofcode.com/2024/day/11
 */
final class Aoc2024Day11 extends SolutionBase
{
    public const YEAR = 2024;
    public const DAY = 11;
    public const TITLE = 'Plutonian Pebbles';
    public const SOLUTIONS = [197157, 234430066982597];
    public const EXAMPLE_SOLUTIONS = [[7, 0], [55312, 0]];

    public const MAX_BLINKS_PART1 = 25;
    public const MAX_BLINKS_PART2 = 75;

    /** @var array<int, int> */
    private array $memo = [];

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
        if (count($input) != 1) {
            throw new \Exception('input must have a single line');
        }
        $data = array_map(intval(...), explode(' ', $input[0]));
        // ---------- Part 1 + 2
        if (count($data) == 5) {
            $max_blinks_part1 = 1;
        } else {
            $max_blinks_part1 = self::MAX_BLINKS_PART1;
        }
        if (count($data) <= 5) {
            $max_blinks_part2 = 1;
        } else {
            $max_blinks_part2 = self::MAX_BLINKS_PART2;
        }
        $this->memo = [];
        $ans1 = 0;
        foreach ($data as $stone) {
            $ans1 += $this->blink($stone, $max_blinks_part1);
        }
        $ans2 = 0;
        foreach ($data as $stone) {
            $ans2 += $this->blink($stone, $max_blinks_part2);
        }
        return [strval($ans1), strval($ans2)];
    }

    private function blink(int $stone, int $count_blinks): int
    {
        if ($count_blinks == 0) {
            return 1;
        }
        $key = $stone | ($count_blinks << 48);
        if (isset($this->memo[$key])) {
            return $this->memo[$key];
        }
        if ($stone == 0) {
            $result = $this->blink(1, $count_blinks - 1);
        } else {
            $stone_string = strval($stone);
            if (strlen($stone_string) % 2 == 0) {
                $divisor = 10 ** intdiv(strlen($stone_string), 2);
                $result = $this->blink(intdiv($stone, $divisor), $count_blinks - 1)
                    + $this->blink($stone % $divisor, $count_blinks - 1);
            } else {
                $result = $this->blink($stone * 2024, $count_blinks - 1);
            }
        }
        $this->memo[$key] = $result;
        return $result;
    }
}
