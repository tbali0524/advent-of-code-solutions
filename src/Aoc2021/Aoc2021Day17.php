<?php

declare(strict_types=1);

namespace TBali\Aoc2021;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2021 Day 17: Trick Shot.
 *
 * Part 1: What is the highest y position it reaches on this trajectory?
 * Part 2: How many distinct initial velocity values cause the probe to be within the target area after any step?
 *
 * Topics: simulation
 *
 * @see https://adventofcode.com/2021/day/17
 */
final class Aoc2021Day17 extends SolutionBase
{
    public const YEAR = 2021;
    public const DAY = 17;
    public const TITLE = 'Trick Shot';
    public const SOLUTIONS = [15400, 5844];
    public const EXAMPLE_SOLUTIONS = [[45, 112]];

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
        $count = sscanf($input[0], 'target area: x=%d..%d, y=%d..%d', $fromX, $toX, $fromY, $toY);
        /** @var int $fromX */
        /** @var int $toX */
        /** @var int $fromY */
        /** @var int $toY */
        if (($count != 4) or ($fromX < 1) or ($toX < $fromX) or ($fromY >= 0) or ($toY < $fromY)) {
            throw new \Exception('Invalid input');
        }
        // ---------- Part 1 + 2
        $minX = intval(floor((-1 + sqrt(1 + 8 * ($fromX - 1))) / 2));
        $ans1 = 0;
        $ans2 = 0;
        for ($sx = $minX; $sx <= $toX; ++$sx) {
            for ($sy = $fromY; $sy <= abs($fromY); ++$sy) {
                $x = 0;
                $y = 0;
                $dx = $sx;
                $dy = $sy;
                $isOk = false;
                while (true) {
                    if (($x >= $fromX) and ($x <= $toX) and ($y >= $fromY) and ($y <= $toY)) {
                        $isOk = true;
                        break;
                    }
                    if (($x > $toX) or ($y < $fromY)) {
                        break;
                    }
                    $x += $dx;
                    $y += $dy;
                    if ($dx > 0) {
                        --$dx;
                    }
                    --$dy;
                }
                if (!$isOk) {
                    continue;
                }
                ++$ans2;
                $maxY = intdiv($sy * ($sy + 1), 2);
                if ($maxY > $ans1) {
                    $ans1 = $maxY;
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}
