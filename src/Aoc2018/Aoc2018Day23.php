<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 23: Experimental Emergency Teleportation.
 *
 * Part 1: Find the nanobot with the largest signal radius. How many nanobots are in range of its signals?
 * Part 2: What is the shortest manhattan distance between any of those points and 0,0,0?
 *
 * @see https://adventofcode.com/2018/day/23
 *
 * @todo complete part 2
 */
final class Aoc2018Day23 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 23;
    public const TITLE = 'Experimental Emergency Teleportation';
    public const SOLUTIONS = [599, 0];
    public const EXAMPLE_SOLUTIONS = [[7, 36]];

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
        $nanobots = array_map(fn (string $line) => Nanobot::fromString($line), $input);
        // ---------- Part 1
        $ans1 = 0;
        usort($nanobots, fn (Nanobot $a, Nanobot $b): int => $b->r <=> $a->r);
        $idxBest = array_key_first($nanobots);
        $bestBot = $nanobots[$idxBest];
        $ans1 = count(array_filter($nanobots, fn (Nanobot $bot): bool => $bestBot->inRange($bot)));
        // ---------- Part 2
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class Nanobot
{
    public function __construct(
        public readonly int $x,
        public readonly int $y,
        public readonly int $z,
        public readonly int $r,
    ) {
    }

    public function inRange(self $bot): bool
    {
        return abs($this->x - $bot->x) + abs($this->y - $bot->y) + abs($this->z - $bot->z) <= $this->r;
    }

    public static function fromString(string $s): self
    {
        $count = sscanf($s, 'pos=<%d,%d,%d>, r=%d', $x, $y, $z, $r);
        if ($count != 4) {
            throw new \Exception('Invalid input');
        }
        return new self(intval($x), intval($y), intval($z), intval($r));
    }
}
