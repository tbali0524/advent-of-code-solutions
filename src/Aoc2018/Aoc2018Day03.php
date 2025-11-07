<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 3: No Matter How You Slice It.
 *
 * Part 1: How many square inches of fabric are within two or more claims?
 * Part 2: What is the ID of the only claim that doesn't overlap?
 *
 * @see https://adventofcode.com/2018/day/3
 */
final class Aoc2018Day03 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 3;
    public const TITLE = 'No Matter How You Slice It';
    public const SOLUTIONS = [118322, 1178];
    public const EXAMPLE_SOLUTIONS = [[4, 3]];

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
        $claims = array_map(Claim::fromString(...), $input);
        // ---------- Part 1 + 2
        $ans1 = 0;
        $claimed = [];
        $hasOverlap = [];
        foreach ($claims as $claim) {
            for ($y = $claim->topY; $y < $claim->topY + $claim->sizeY; ++$y) {
                for ($x = $claim->topX; $x < $claim->topX + $claim->sizeX; ++$x) {
                    if (!isset($claimed[$y][$x])) {
                        $claimed[$y][$x] = $claim->id;
                    } else {
                        if ($claimed[$y][$x] >= 0) {
                            ++$ans1;
                            $hasOverlap[$claimed[$y][$x]] = true;
                            $claimed[$y][$x] = -1;
                        }
                        $hasOverlap[$claim->id] = true;
                    }
                }
            }
        }
        $ans2 = 0;
        foreach ($claims as $claim) {
            if (!isset($hasOverlap[$claim->id])) {
                $ans2 = $claim->id;
                break;
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class Claim
{
    public function __construct(
        public readonly int $id,
        public readonly int $topX,
        public readonly int $topY,
        public readonly int $sizeX,
        public readonly int $sizeY,
    ) {
    }

    public static function fromString(string $s): self
    {
        $count = sscanf($s, '#%d @ %d,%d: %dx%d', $id, $topX, $topY, $sizeX, $sizeY);
        if ($count != 5) {
            throw new \Exception('Invalid input');
        }
        return new self(intval($id), intval($topX), intval($topY), intval($sizeX), intval($sizeY));
    }
}
