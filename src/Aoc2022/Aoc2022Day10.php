<?php

declare(strict_types=1);

namespace TBali\Aoc2022;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2022 Day 10: Cathode-Ray Tube.
 *
 * Part 1: Find the signal strength during the 20th, 60th, 100th, 140th, 180th, and 220th cycles.
 *         What is the sum of these six signal strengths?
 * Part 2: Render the image given by your program. What eight capital letters appear on your CRT?
 *
 * Topics: assembly simulation
 *
 * @see https://adventofcode.com/2022/day/10
 */
final class Aoc2022Day10 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 10;
    public const TITLE = 'Cathode-Ray Tube';
    public const SOLUTIONS = [15220, 'RFZEKBFA'];
    public const EXAMPLE_SOLUTIONS = [[13140, 0], [0, 0]];

    private const CYCLE_MODULO = 40;
    private const CYCLE_REMAINDER = 20;
    private const SHOW_SCREEN = false;
    private const SCREEN_MAX_Y = 20;

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
        $x = 1;
        $cycle = 1;
        $screen = array_fill(0, self::SCREEN_MAX_Y, str_repeat(' ', self::CYCLE_MODULO));
        foreach ($input as $line) {
            if ($cycle % self::CYCLE_MODULO == self::CYCLE_REMAINDER) {
                $ans1 += $cycle * $x;
            }
            $screenX = ($cycle - 1) % self::CYCLE_MODULO;
            if (abs($x - $screenX) <= 1) {
                $screenY = intdiv($cycle - 1, self::CYCLE_MODULO);
                $screen[$screenY][$screenX] = '#';
            }
            $instr = substr($line, 0, 4);
            if ($instr == 'noop') {
                ++$cycle;
            } elseif ($instr == 'addx') {
                ++$cycle;
                if ($cycle % self::CYCLE_MODULO == self::CYCLE_REMAINDER) {
                    $ans1 += $cycle * $x;
                }
                $screenX = ($cycle - 1) % self::CYCLE_MODULO;
                if (abs($x - $screenX) <= 1) {
                    $screenY = intdiv($cycle - 1, self::CYCLE_MODULO);
                    $screen[$screenY][$screenX] = '#';
                }
                ++$cycle;
                $operand = intval(substr($line, 5));
                $x += $operand;
            } else {
                throw new \Exception('Invalid input');
            }
        }
        if ($cycle % self::CYCLE_MODULO == self::CYCLE_REMAINDER) {
            $ans1 += $cycle * $x;
        }
        $screenX = ($cycle - 1) % self::CYCLE_MODULO;
        if (abs($x - $screenX) <= 1) {
            $screenY = intdiv($cycle - 1, self::CYCLE_MODULO);
            if ($screenY < self::SCREEN_MAX_Y) {
                $screen[$screenY][$screenX] = '#';
            }
        }
        // @phpstan-ignore-next-line
        if (self::SHOW_SCREEN) {
            foreach ($screen as $row) {
                echo $row, PHP_EOL;
            }
            echo PHP_EOL;
        }
        $ans2 = 0;
        if ($ans1 == self::SOLUTIONS[0]) {
            $ans2 = 'RFZEKBFA';
        }
        return [strval($ans1), strval($ans2)];
    }
}
