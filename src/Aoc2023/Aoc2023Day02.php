<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2023;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2023 Day 2: Cube Conundrum.
 *
 * Part 1: What is the sum of the IDs of those games?
 * Part 2: What is the sum of the power of these sets?
 *
 * @see https://adventofcode.com/2023/day/2
 */
final class Aoc2023Day02 extends SolutionBase
{
    public const YEAR = 2023;
    public const DAY = 2;
    public const TITLE = 'Cube Conundrum';
    public const SOLUTIONS = [2617, 59795];
    public const EXAMPLE_SOLUTIONS = [[8, 2286]];

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
        $ans2 = 0;
        $bag = new Hand(12, 13, 14);
        foreach ($input as $line) {
            $a = explode(': ', $line);
            if ((count($a) != 2) or !str_starts_with($line, 'Game ')) {
                throw new \Exception('Invalid input');
            }
            $id = intval(substr($a[0], 5));
            $isOk = true;
            $minBag = new Hand();
            $handStrings = explode('; ', $a[1]);
            foreach ($handStrings as $handString) {
                $hand = new Hand();
                $items = explode(', ', $handString);
                foreach ($items as $item) {
                    $b = explode(' ', $item);
                    $count = intval($b[0]);
                    match ($b[1] ?? '-') {
                        'red' => $hand->red = $count,
                        'green' => $hand->green = $count,
                        'blue' => $hand->blue = $count,
                        default => throw new \Exception('Invalid input'),
                    };
                    match ($b[1] ?? '-') {
                        'red' => $minBag->red = intval(max($minBag->red, $hand->red)),
                        'green' => $minBag->green = intval(max($minBag->green, $hand->green)),
                        'blue' => $minBag->blue = intval(max($minBag->blue, $hand->blue)),
                        default => throw new \Exception('Invalid input'),
                    };
                }
                if (!$hand->isPossible($bag)) {
                    $isOk = false;
                }
            }
            if ($isOk) {
                $ans1 += $id;
            }
            $ans2 += $minBag->power();
        }
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class Hand
{
    public function __construct(
        public int $red = 0,
        public int $green = 0,
        public int $blue = 0,
    ) {
    }

    public function isPossible(Hand $bag): bool
    {
        return $this->red <= $bag->red && $this->green <= $bag->green && $this->blue <= $bag->blue;
    }

    public function power(): int
    {
        return $this->red * $this->green * $this->blue;
    }
}
