<?php

declare(strict_types=1);

namespace TBali\Aoc2016;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2016 Day 17: Two Steps Forward.
 *
 * Part 1: Given your vault's passcode, what is the shortest path (the actual path, not just the length)
 *         to reach the vault?
 * Part 2: What is the length of the longest path that reaches the vault?
 *
 * Topics: BFS
 *
 * @see https://adventofcode.com/2016/day/17
 */
final class Aoc2016Day17 extends SolutionBase
{
    public const YEAR = 2016;
    public const DAY = 17;
    public const TITLE = 'Two Steps Forward';
    public const SOLUTIONS = ['DUDRLRRDDR', 788];
    public const STRING_INPUT = 'lpvhkcbi';
    public const EXAMPLE_SOLUTIONS = [['DDRRRD', 370], ['DRURDRUDDLLDLUURRDULRLDUUDDDRR', 830]];
    public const EXAMPLE_STRING_INPUTS = ['ihgpwlah', 'ulqzkmiv'];

    private const MAX_X = 4;
    private const MAX_Y = 4;
    private const DIR_NAMES = 'UDLR';
    private const DELTAS = [[0, -1], [0, 1], [-1, 0], [1, 0]];

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
        $ans1 = '';
        $ans2 = 0;
        $x = 0;
        $y = 0;
        $q = [[$x, $y, '']];
        $readIdx = 0;
        while (true) {
            if ($readIdx >= count($q)) {
                break;
            }
            [$x, $y, $path] = $q[$readIdx];
            ++$readIdx;
            if (($x == self::MAX_X - 1) and ($y == self::MAX_Y - 1)) {
                if ($ans1 == '') {
                    $ans1 = $path;
                }
                $ans2 = max($ans2, strlen($path));
                continue;
            }
            $lock = md5($salt . $path);
            foreach (self::DELTAS as $dir => [$dx, $dy]) {
                [$x1, $y1] = [$x + $dx, $y + $dy];
                if (($x1 < 0) or ($x1 >= self::MAX_X) or ($y1 < 0) or ($y1 >= self::MAX_X)) {
                    continue;
                }
                if (!str_contains('bcdef', $lock[$dir])) {
                    continue;
                }
                $q[] = [$x1, $y1, $path . self::DIR_NAMES[$dir]];
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}
