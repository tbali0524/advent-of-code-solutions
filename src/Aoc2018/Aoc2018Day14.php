<?php

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 14: Chocolate Charts.
 *
 * Part 1: What are the scores of the ten recipes immediately after the number of recipes in your puzzle input?
 * Part 2: How many recipes appear on the scoreboard to the left of the score sequence in your puzzle input?
 *
 * @see https://adventofcode.com/2018/day/14
 */
final class Aoc2018Day14 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 14;
    public const TITLE = 'Chocolate Charts';
    public const SOLUTIONS = ['1191216109', '20268576'];
    public const STRING_INPUT = '190221';
    public const EXAMPLE_SOLUTIONS = [
        ['5158916779', 0],
        ['0124515891', 0],
        ['9251071085', 0],
        ['5941429882', 0],
        [0, 9],
        [0, 5],
        [0, 18],
        [0, 2018],
    ];
    public const EXAMPLE_STRING_INPUTS = ['9', '5', '18', '2018', '51589', '01245', '92510', '59414'];

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
        $maxRecipes = intval($input[0]);
        $targetRecipe = $input[0];
        // ---------- Part 1 + 2
        $recipes = str_repeat('.', $maxRecipes);
        $recipes[0] = '3';
        $recipes[1] = '7';
        $countRecipes = 2;
        $idx0 = 0;
        $idx1 = 1;
        $ans1 = '';
        $ans2 = 0;
        while (true) {
            $score0 = intval($recipes[$idx0]);
            $score1 = intval($recipes[$idx1]);
            $score = strval($score0 + $score1);
            for ($i = 0; $i < strlen($score); ++$i) {
                $recipes[$countRecipes + $i] = $score[$i];
            }
            $countRecipes += strlen($score);
            $idx0 = ($idx0 + $score0 + 1) % $countRecipes;
            $idx1 = ($idx1 + $score1 + 1) % $countRecipes;
            if (($ans1 == '') and ($countRecipes >= $maxRecipes + 10)) {
                $ans1 = substr($recipes, $maxRecipes, 10);
            }
            if (($ans2 == 0) and ($countRecipes >= strlen($targetRecipe))) {
                $from = max(0, $countRecipes - strlen($score) - strlen($targetRecipe) + 1);
                $haystack = substr($recipes, $from, $countRecipes - $from);
                $pos = strpos($haystack, $targetRecipe);
                if ($pos !== false) {
                    $ans2 = $pos + $from;
                }
            }
            if (($ans1 != '') and ($ans2 != 0)) {
                break;
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}
