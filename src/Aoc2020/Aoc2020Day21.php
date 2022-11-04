<?php

/*
https://adventofcode.com/2020/day/21
Part 1: Determine which ingredients cannot possibly contain any of the allergens in your list.
    How many times do any of those ingredients appear?
Part 2: What is your canonical dangerous ingredient list?
Topics: Bipartite graph, matching
*/

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

final class Aoc2020Day21 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 21;
    public const TITLE = 'Allergen Assessment';
    public const SOLUTIONS = [2380, 'ktpbgdn,pnpfjb,ndfb,rdhljms,xzfj,bfgcms,fkcmf,hdqkqhh'];
    public const EXAMPLE_SOLUTIONS = [[5, 'mxmxvkd,sqjhc,fvjkl'], [0, 0]];

    /** @var array<string, int> */
    private array $ingredients;
    /** @var array<string, int> */
    private array $allergens;
    /** @var array<array{int[], int[]}> */
    private array $recipes; // each row is a [list if ingredients id, list of allergens id]

    /** @var array<int, array<int, true>> */
    private array $canComeFrom;      // [allergen][ingredient => true]
    /** @var array<int, array<int, true>> */
    private array $canContain;      // [ingredient][allergen => true]

    /**
     * @param string[] $input
     *
     * @return array{string, string}
     */
    public function solve(array $input): array
    {
        $this->parseInput($input);
        // ---------- Part 1
        $this->canComeFrom = [];
        $this->canContain = [];
        foreach ($this->recipes as $recipe) {
            $idIngreds = [];
            foreach ($recipe[0] as $idIngred) {
                $idIngreds[$idIngred] = true;
            }
            foreach ($recipe[1] as $idAllerg) {
                if (count($this->canComeFrom[$idAllerg] ?? []) == 0) {
                    foreach ($idIngreds as $idIngred => $true) {
                        $this->canComeFrom[$idAllerg][$idIngred] = true;
                        $this->canContain[$idIngred][$idAllerg] = true;
                    }
                } else {
                    foreach (array_keys($this->canComeFrom[$idAllerg]) as $idIngred) {
                        if (!isset($idIngreds[$idIngred])) {
                            unset(
                                $this->canComeFrom[$idAllerg][$idIngred],
                                $this->canContain[$idIngred][$idAllerg]
                            );
                        }
                    }
                }
            }
        }
        $ans1 = 0;
        foreach ($this->recipes as $recipe) {
            foreach ($recipe[0] as $idIngred) {
                if (count($this->canContain[$idIngred] ?? []) == 0) {
                    ++$ans1;
                }
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        $remainingAllergs = array_fill(0, count($this->allergens), true);
        $pairs = [];
        while (count($remainingAllergs) > 0) {
            $idBestAllerg = -1;
            $best = PHP_INT_MAX;
            foreach ($remainingAllergs as $idAllerg => $true) {
                $current = count($this->canComeFrom[$idAllerg]);
                if ($current < $best) {
                    $idBestAllerg = $idAllerg;
                    $best = $current;
                }
            }
            if ($best != 1) {
                throw new \Exception('No solution found');
            }
            $idIngred = array_key_first($this->canComeFrom[$idBestAllerg]);
            $nameIngred = array_search($idIngred, $this->ingredients);
            $nameAllerg = array_search($idBestAllerg, $this->allergens);
            if (($nameIngred === false) or ($nameAllerg === false)) {
                throw new \Exception('No solution found');
            }
            $pairs[$nameIngred] = $nameAllerg;
            unset($remainingAllergs[$idBestAllerg]);
            foreach ($this->canComeFrom as $idAllerg => $list) {
                unset($this->canComeFrom[$idAllerg][$idIngred]);
            }
        }
        asort($pairs, SORT_STRING);
        $ans2 = implode(',', array_keys($pairs));
        return [strval($ans1), strval($ans2)];
    }

    private function addOrGetIngredient(string $name): int
    {
        if (isset($this->ingredients[$name])) {
            return $this->ingredients[$name];
        }
        $id = count($this->ingredients);
        $this->ingredients[$name] = $id;
        return $id;
    }

    private function addOrGetAllergen(string $name): int
    {
        if (isset($this->allergens[$name])) {
            return $this->allergens[$name];
        }
        $id = count($this->allergens);
        $this->allergens[$name] = $id;
        return $id;
    }

    /**
     * @param string[] $input
     */
    private function parseInput(array $input): void
    {
        $this->ingredients = [];
        $this->allergens = [];
        $this->recipes = [];
        foreach ($input as $line) {
            $a = explode(' (contains ', $line);
            if (count($a) != 2) {
                throw new \Exception('Invalid input');
            }
            $idIngreds = [];
            foreach (explode(' ', $a[0]) as $name) {
                $idIngreds[] = $this->addOrGetIngredient($name);
            }
            $idAllergs = [];
            foreach (explode(', ', substr($a[1], 0, -1)) as $name) {
                $idAllergs[] = $this->addOrGetAllergen($name);
            }
            $this->recipes[] = [$idIngreds, $idAllergs];
        }
    }
}
