<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2019;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2019 Day 14: Space Stoichiometry.
 *
 * Part 1: What is the minimum amount of ORE required to produce exactly 1 FUEL?
 * Part 2: Given 1 trillion ORE, what is the maximum amount of FUEL you can produce?
 *
 * Topics: binary search
 *
 * @see https://adventofcode.com/2019/day/14
 */
final class Aoc2019Day14 extends SolutionBase
{
    public const YEAR = 2019;
    public const DAY = 14;
    public const TITLE = 'Space Stoichiometry';
    public const SOLUTIONS = [346961, 4065790];
    public const EXAMPLE_SOLUTIONS = [[31, 0], [165, 0], [13312, 82892753], [180697, 5586022], [2210736, 460664]];

    public const ORE_PART2 = 1_000_000_000_000;

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
        // ---------- Parse input
        $recipes = [];
        foreach ($input as $line) {
            $r = Recipe::fromString($line);
            $recipes[$r->name] = $r;
        }
        // ---------- Part 1
        $ans1 = $this->getCost($recipes, 1);
        // ---------- Part 2
        if (count($input) <= 7) {
            return [strval($ans1), '0'];
        }
        $ans2 = 0;
        $low = intdiv(self::ORE_PART2, $ans1);
        $high = 2 * $low;
        while ($low + 1 < $high) {
            $mid = intdiv($low + $high, 2);
            $cost = $this->getCost($recipes, $mid);
            if ($cost < self::ORE_PART2) {
                $low = $mid;
            } elseif ($cost > self::ORE_PART2) {
                $high = $mid;
            } else {
                $high = $mid;
                break;
            }
        }
        $ans2 = $high;
        if ($this->getCost($recipes, $ans2) > self::ORE_PART2) {
            --$ans2;
        }
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<string, Recipe> $recipes
     */
    private function getCost(array $recipes, int $fuel = 1): int
    {
        $remainingRecipes = $recipes;
        $bom = [Recipe::FUEL => $fuel];
        $toName = Recipe::FUEL;
        $remainingMaterials = [];
        while (true) {
            if ((count($bom) == 1) and (isset($bom[Recipe::ORE]))) {
                return $bom[Recipe::ORE];
            }
            if (count($remainingRecipes) == 0) {
                // @codeCoverageIgnoreStart
                throw new \Exception('No solution found');
                // @codeCoverageIgnoreEnd
            }
            unset($remainingRecipes[$toName]);
            $countUsedBy = [];
            foreach ($remainingRecipes as $recipe) {
                $countUsedBy[$recipe->name] ??= 0;
                foreach (array_keys($recipe->bom) as $name) {
                    $countUsedBy[$name] = ($countUsedBy[$name] ?? 0) + 1;
                }
            }
            asort($countUsedBy);
            if (!isset($bom[$toName])) {
                continue;
            }
            $toQty = $bom[$toName];
            if ($toName == Recipe::ORE) {
                continue;
            }
            $recipe = $recipes[$toName];
            $count = intval(ceil($toQty / $recipe->qty));
            foreach ($recipe->bom as $fromName => $fromQty) {
                $bom[$fromName] = ($bom[$fromName] ?? 0) + $fromQty * $count;
            }
            $bom[$toName] -= $recipe->qty * $count;
            if ($bom[$toName] <= 0) {
                if ($bom[$toName] < 0) {
                    $remainingMaterials[$toName] = ($remainingMaterials[$toName] ?? 0) + -$bom[$toName];
                }
                unset($bom[$toName]);
            }
            $toName = array_key_first($countUsedBy) ?? '';
        }
    }
}

// --------------------------------------------------------------------
final class Recipe
{
    public const string ORE = 'ORE';
    public const string FUEL = 'FUEL';

    public string $name = '';
    public int $qty = 0;
    /** @var array<string, int> */
    public array $bom = [];

    public static function fromString(string $s): self
    {
        $a = explode(' => ', $s);
        if (count($a) != 2) {
            throw new \Exception('Invalid input');
        }
        $b = explode(' ', $a[1]);
        if (count($b) != 2) {
            throw new \Exception('Invalid input');
        }
        $list = explode(', ', $a[0]);
        $recipe = new self();
        $recipe->name = $b[1];
        $recipe->qty = intval($b[0]);
        foreach ($list as $part) {
            $c = explode(' ', $part);
            if (count($c) != 2) {
                throw new \Exception('Invalid input');
            }
            $recipe->bom[$c[1]] = intval($c[0]);
        }
        return $recipe;
    }
}
