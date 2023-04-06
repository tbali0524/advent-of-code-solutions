<?php

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 15: Chiton.
 *
 * Part 1: What is the lowest total risk of any path from the top left to the bottom right?
 * Part 2: Using the full map, what is the lowest total risk of any path from the top left to the bottom right?
 *
 * Topics: pathfinding, A-Star (A*)
 *
 * @see https://adventofcode.com/2021/day/15
 */
final class Aoc2021Day15 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 15;
    public const TITLE = 'Chiton';
    public const SOLUTIONS = [613, 2899];
    public const EXAMPLE_SOLUTIONS = [[40, 315]];

    private const INFINITY = (PHP_INT_MAX >> 2); // to avoid ovwerflow with additions
    private const REPEAT_PART2 = 5;

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
        $maxY = count($input);
        $maxX = strlen($input[0]);
        // ---------- Part 1
        $ans1 = 0;
        // @see https://en.wikipedia.org/wiki/A*_search_algorithm
        $openSet = new \SplPriorityQueue(); // max-heap, so priority must be set to -cost
        $startState = [0, 0, 0]; // x, y, risk
        $openSet->insert($startState, 0);
        $gScore = ['0 0' => 0];
        while (true) {
            if ($openSet->isEmpty()) {
                // @codeCoverageIgnoreStart
                throw new \Exception('No solution found');
                // @codeCoverageIgnoreEnd
            }
            $current = $openSet->extract();
            /** @phpstan-var array{int, int, int} $current */
            [$x, $y, $risk] = $current;
            if (($x == $maxX - 1) and ($y == $maxY - 1)) {
                $ans1 = $risk;
                break;
            }
            foreach ([[1, 0], [0, 1], [-1, 0], [0, -1]] as [$dx, $dy]) {
                $x1 = $x + $dx;
                $y1 = $y + $dy;
                if (($x1 < 0) or ($x1 >= $maxX) or ($y1 < 0) or ($y1 >= $maxY)) {
                    continue;
                }
                $costStep = intval($input[$y1][$x1]);
                $hash = $x . ' ' . $y;
                $tentativegScore = ($gScore[$hash] ?? self::INFINITY) + $costStep;
                $hash1 = $x1 . ' ' . $y1;
                if ($tentativegScore >= ($gScore[$hash1] ?? self::INFINITY)) {
                    continue;
                }
                $gScore[$hash1] = $tentativegScore;
                $fScore = $tentativegScore + abs($maxX - 1 - $x1) + abs($maxY - 1 - $y1);
                $openSet->insert([$x1, $y1, $risk + $costStep], -$fScore);
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        $targetX = $maxX * self::REPEAT_PART2 - 1;
        $targetY = $maxY * self::REPEAT_PART2 - 1;
        $openSet = new \SplPriorityQueue(); // max-heap, so priority must be set to -cost
        $startState = [0, 0, 0]; // x, y, risk
        $openSet->insert($startState, 0);
        $gScore = ['0 0' => 0];
        while (true) {
            if ($openSet->isEmpty()) {
                // @codeCoverageIgnoreStart
                throw new \Exception('No solution found');
                // @codeCoverageIgnoreEnd
            }
            $current = $openSet->extract();
            /** @phpstan-var array{int, int, int} $current */
            [$x, $y, $risk] = $current;
            if (($x == $targetX) and ($y == $targetY)) {
                $ans2 = $risk;
                break;
            }
            foreach ([[1, 0], [0, 1], [-1, 0], [0, -1]] as [$dx, $dy]) {
                $x1 = $x + $dx;
                $y1 = $y + $dy;
                if (($x1 < 0) or ($x1 > $targetX) or ($y1 < 0) or ($y1 > $targetY)) {
                    continue;
                }
                $repeat = intdiv($x1, $maxX) + intdiv($y1, $maxY);
                $costStep = intval($input[$y1 % $maxY][$x1 % $maxX]) + $repeat;
                if ($costStep > 9) {
                    $costStep -= 9;
                }
                $hash = $x . ' ' . $y;
                $tentativegScore = ($gScore[$hash] ?? self::INFINITY) + $costStep;
                $hash1 = $x1 . ' ' . $y1;
                if ($tentativegScore >= ($gScore[$hash1] ?? self::INFINITY)) {
                    continue;
                }
                $gScore[$hash1] = $tentativegScore;
                $fScore = $tentativegScore + abs($targetX - $x1) + abs($targetY - $y1);
                $openSet->insert([$x1, $y1, $risk + $costStep], -$fScore);
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}
