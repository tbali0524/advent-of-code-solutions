<?php

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 2: 1202 Program Alarm.
 *
 * Part 1: What value is left at position 0 after the program halts?
 * Part 2: Find the input noun and verb that cause the program to produce the output 19690720.
 *         What is 100 * noun + verb?
 *
 * Topics: assembly simulation
 *
 * @see https://adventofcode.com/2019/day/2
 */
final class Aoc2019Day02 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 2;
    public const TITLE = '1202 Program Alarm';
    public const SOLUTIONS = [3085697, 9425];
    public const EXAMPLE_SOLUTIONS = [[3500, 0], [30, 0]];

    private const TARGET_PART2 = 19690720;

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
        /** @var array<int, int> */
        $data = array_map(intval(...), explode(',', $input[0]));
        // ---------- Part 1
        $memory = $data;
        if (count($data) > 12) {
            $memory[1] = 12;
            $memory[2] = 2;
        }
        $ans1 = $this->simulate($memory);
        // ---------- Part 2
        $ans2 = 0;
        if (count($data) <= 12) {
            return [strval($ans1), strval($ans2)];
        }
        for ($noun = 0; $noun < 100; ++$noun) {
            for ($verb = 0; $verb < 100; ++$verb) {
                $memory = $data;
                $memory[1] = $noun;
                $memory[2] = $verb;
                if ($this->simulate($memory) == self::TARGET_PART2) {
                    $ans2 = 100 * $noun + $verb;
                    break 2;
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, int> $memory
     */
    private function simulate(array $memory): int
    {
        $ic = 0;
        while (true) {
            if ($ic >= count($memory)) {
                throw new \Exception('Invalid input');
            }
            $opcode = $memory[$ic];
            if ($opcode == 99) {
                break;
            }
            if ($ic >= count($memory) - 3) {
                throw new \Exception('Invalid input');
            }
            $param1 = $memory[$ic + 1];
            $param2 = $memory[$ic + 2];
            $param3 = $memory[$ic + 3];
            $memory[$param3] = match ($opcode) {
                1 => $memory[$param1] + $memory[$param2],
                2 => $memory[$param1] * $memory[$param2],
                default => throw new \Exception('Invalid input'),
            };
            $ic += 4;
        }
        return $memory[0];
    }
}
