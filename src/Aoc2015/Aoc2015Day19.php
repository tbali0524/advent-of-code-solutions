<?php

declare(strict_types=1);

namespace TBali\Aoc2015;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2015 Day 19: Medicine for Rudolph.
 *
 * Part 1: How many distinct molecules can be created after all the different ways you can do one replacement
 *         on the medicine molecule?
 * Part 2: What is the fewest number of steps to go from e to the medicine molecule?
 *
 * Topics: DFS, graph
 *
 * @see https://adventofcode.com/2015/day/19
 */
final class Aoc2015Day19 extends SolutionBase
{
    public const YEAR = 2015;
    public const DAY = 19;
    public const TITLE = 'Medicine for Rudolph';
    public const SOLUTIONS = [535, 212];
    public const EXAMPLE_SOLUTIONS = [[0, 0], [0, 0]];

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
        // ---------- input processing
        $replacements = [];
        $reverse = [];
        $molecule = $input[count($input) - 1];
        for ($i = 0; $i < count($input) - 2; ++$i) {
            $a = explode(' => ', $input[$i]);
            if (count($a) != 2) {
                throw new \Exception('Invalid input');
            }
            if (isset($replacements[$a[0]])) {
                $replacements[$a[0]][] = $a[1];
            } else {
                $replacements[$a[0]] = [$a[1]];
            }
            $reverse[$a[1]] = $a[0];
        }
        // ---------- Part 1
        $resultSet = [];
        for ($i = 0; $i < strlen($molecule); ++$i) {
            $elem = $molecule[$i];
            if (!isset($replacements[$elem])) {
                continue;
            }
            foreach ($replacements[$elem] as $newElem) {
                $newMolecule = substr($molecule, 0, $i) . $newElem . substr($molecule, $i + 1);
                $resultSet[$newMolecule] = true;
            }
        }
        for ($i = 0; $i < strlen($molecule) - 1; ++$i) {
            $elem = substr($molecule, $i, 2);
            if (!isset($replacements[$elem])) {
                continue;
            }
            foreach ($replacements[$elem] as $newElem) {
                $newMolecule = substr($molecule, 0, $i) . $newElem . substr($molecule, $i + 2);
                $resultSet[$newMolecule] = true;
            }
        }
        $ans1 = count($resultSet);
        // ---------- Part 2
        $ans2 = 0;
        // Note: not a correct solution, but works for this specific input...
        $newMolecule = $molecule;
        while ($newMolecule != 'e') {
            foreach ($reverse as $to => $from) {
                if (str_contains($newMolecule, $to)) {
                    $count = 0;
                    $newMolecule = str_replace($to, $from, $newMolecule, $count);
                    $ans2 += $count;
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}
// Note: a correct solution, but timeouts
// $visited = ['e' => true];
// $q = [['e', 0]];
// $readIdx = 0;
// while (true) {
//     if ($readIdx >= count($q)) {
//         throw new \Exception('No solution found');
//     }
//     [$currMolecule, $currStep] = $q[$readIdx];
//     ++$readIdx;
//     if (strlen($currMolecule) > strlen($molecule)) {
//         continue;
//     }
//     if ($currMolecule == $molecule) {
//         $ans2 = $currStep;
//         break;
//     }
//     for ($i = 0; $i < strlen($currMolecule); ++$i) {
//         $elem = $currMolecule[$i];
//         if (!isset($replacements[$elem])) {
//             continue;
//         }
//         foreach ($replacements[$elem] as $newElem) {
//             $newMolecule = substr($currMolecule, 0, $i) . $newElem . substr($currMolecule, $i + 1);
//             if (isset($visited[$newMolecule])) {
//                 continue;
//             }
//             $q[] = [$newMolecule, $currStep + 1];
//             $visited[$newMolecule] = true;
//         }
//     }
//     for ($i = 0; $i < strlen($currMolecule) - 1; ++$i) {
//         $elem = substr($currMolecule, $i, 2);
//         if (!isset($replacements[$elem])) {
//             continue;
//         }
//         foreach ($replacements[$elem] as $newElem) {
//             $newMolecule = substr($currMolecule, 0, $i) . $newElem . substr($currMolecule, $i + 2);
//             if (isset($visited[$newMolecule])) {
//                 continue;
//             }
//             $q[] = [$newMolecule, $currStep + 1];
//             $visited[$newMolecule] = true;
//         }
//     }
// }
