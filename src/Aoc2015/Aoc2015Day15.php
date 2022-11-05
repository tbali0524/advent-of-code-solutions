<?php

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2015 Day 15: Science for Hungry People.
 *
 * Part 1: What is the total score of the highest-scoring cookie you can make?
 * Part 2: What is the total score of the highest-scoring cookie you can make with a calorie total of 500?
 *
 * @see https://adventofcode.com/2015/day/15
 */
final class Aoc2015Day15 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 15;
    public const TITLE = 'Science for Hungry People';
    public const SOLUTIONS = [21367368, 1766400];
    public const EXAMPLE_SOLUTIONS = [[62842880, 57600000], [0, 0]];

    private const TOTAL_QUANTITY = 101; // must be total + 1!!!

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
        $ingredients = $this->parseInput($input);
        $powers = array_map(fn (int $x): int => self::TOTAL_QUANTITY ** $x, range(0, count($ingredients)));
        for ($code = 0; $code < $powers[count($ingredients) - 1]; ++$code) {
            $quantities = [];
            $remaining_quantity = self::TOTAL_QUANTITY - 1;
            for ($idx = 0; $idx < count($ingredients) - 1; ++$idx) {
                $qty = intdiv($code, $powers[$idx]) % self::TOTAL_QUANTITY;
                $quantities[] = $qty;
                $remaining_quantity -= $qty;
                if ($remaining_quantity < 0) {
                    break;
                }
            }
            if ($remaining_quantity < 0) {
                continue;
            }
            $quantities[] = $remaining_quantity;
            $product = 1;
            foreach (['capacity', 'durability', 'flavor', 'texture'] as $property) {
                $sum = 0;
                foreach ($ingredients as $idx => $ingredient) {
                    $sum += ($ingredient[$property] ?? 0) * $quantities[$idx];
                }
                $sum = max(0, $sum);
                $product *= $sum;
            }
            $sum_calory = 0;
            foreach ($ingredients as $idx => $ingredient) {
                $sum_calory += ($ingredient['calories'] ?? 0) * $quantities[$idx];
            }
            $ans1 = max($ans1, $product);
            if ($sum_calory == 500) {
                $ans2 = max($ans2, $product);
            }
        }
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, string> $input
     *
     * @return array<int, array<string, int>>
     */
    private function parseInput(array $input): array
    {
        $ingredients = [];
        foreach ($input as $line) {
            $a = explode(' ', $line);
            if (count($a) != 11) {
                throw new \Exception('Invalid input');
            }
            $ingredient = [];
            for ($i = 0; $i < 5; ++$i) {
                $propName = $a[1 + 2 * $i];
                if ($i < 4) {
                    $propValue = intval(substr($a[2 + 2 * $i], 0, -1));
                } else {
                    $propValue = intval($a[10]);
                }
                $ingredient[$propName] = $propValue;
            }
            // $ingredient['name'] = substr($a[0], 0, -1);
            $ingredients[] = $ingredient;
        }
        return $ingredients;
    }
}
