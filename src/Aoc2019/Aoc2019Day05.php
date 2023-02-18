<?php

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 5: Sunny with a Chance of Asteroids.
 *
 * Part 1: After providing 1 to the only input instruction and passing all the tests,
 *         what diagnostic code does the program produce?
 * Part 2: What is the diagnostic code for system ID 5?
 *
 * Topics: assembly simulation
 *
 * @see https://adventofcode.com/2019/day/5
 */
final class Aoc2019Day05 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 5;
    public const TITLE = 'Sunny with a Chance of Asteroids';
    public const SOLUTIONS = [4511442, 12648139];

    private const INSTRUCTION_LENGTHS = [1 => 4, 2 => 4, 3 => 2, 4 => 2, 5 => 3, 6 => 3, 7 => 4, 8 => 4, 99 => 1];

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
        // ---------- Part 1 + 2
        $memory = $data;
        $ans1 = $this->simulate($memory, [1]);
        $ans2 = $this->simulate($memory, [5]);
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, int> $memory
     * @param array<int, int> $inputs
     */
    private function simulate(array $memory, array $inputs): int
    {
        $idxInput = 0;
        $output = [];
        $ic = 0;
        while (true) {
            if ($ic >= count($memory)) {
                throw new \Exception('Invalid input');
            }
            $opcode = $memory[$ic] % 100;
            if ($opcode == 99) {
                break;
            }
            $len = self::INSTRUCTION_LENGTHS[$opcode] ?? throw new \Exception('Invalid input');
            if ($ic > count($memory) - $len) {
                throw new \Exception('Invalid input');
            }
            $params = [];
            for ($i = 1; $i < $len; ++$i) {
                $mode = intdiv($memory[$ic], 10 ** ($i + 1)) % 10;
                $params[$i] = match ($mode) {
                    0 => $memory[$memory[$ic + $i]] ?? throw new \Exception('Invalid input'), // position mode
                    1 => $memory[$ic + $i], // immediate mode
                    default => throw new \Exception('Invalid input'),
                };
            }
            $oldIc = $ic;
            match ($opcode) {
                1 => $memory[$memory[$ic + 3]] = $params[1] + $params[2],
                2 => $memory[$memory[$ic + 3]] = $params[1] * $params[2],
                3 => $memory[$memory[$ic + 1]] = $inputs[$idxInput++] ?? throw new \Exception('Invalid input'),
                4 => $output[] = $params[1],
                5 => $ic = $params[1] != 0 ? $params[2] : $ic,
                6 => $ic = $params[1] == 0 ? $params[2] : $ic,
                7 => $memory[$memory[$ic + 3]] = $params[1] < $params[2] ? 1 : 0,
                8 => $memory[$memory[$ic + 3]] = $params[1] == $params[2] ? 1 : 0,
                default => throw new \Exception('Invalid input'),
            };
            if ($ic == $oldIc) {
                $ic += $len;
            }
        }
        $result = array_values(array_filter($output, fn (int $x): bool => $x != 0));
        if (count($result) != 1) {
            // @codeCoverageIgnoreStart
            throw new \Exception('Invalid input');
            // @codeCoverageIgnoreEnd
        }
        return $result[0];
    }
}
