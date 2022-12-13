<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2020 Day 7: Handy Haversacks.
 *
 * Part 1: How many bag colors can eventually contain at least one shiny gold bag?
 * Part 2: How many individual bags are required inside your single shiny gold bag?
 *
 * Topics: input parsing
 *
 * @see https://adventofcode.com/2020/day/7
 */
final class Aoc2020Day07 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 7;
    public const TITLE = 'Handy Haversacks';
    public const SOLUTIONS = [115, 1250];
    public const EXAMPLE_SOLUTIONS = [[4, 32]];

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
        $g = new BagRegulations($input);
        $ans1 = $g->getSumContainerBags('shiny gold');
        $ans2 = $g->getSumContainedBags('shiny gold');
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class BagRegulations
{
    /** @var array<string, array<string, int>> */
    private array $contains;
    /** @var array<string, array<int, string>> */
    private array $containedBy;
    /** @var array<string, int> */
    private array $memo = [];

    /**
     * @param array<int, string> $input The lines of the input, without LF
     */
    public function __construct(array $input = [])
    {
        $this->contains = [];
        $this->containedBy = [];
        foreach ($input as $line) {
            $a = explode(' ', $line);
            if ((count($a) < 7) or ($a[2] != 'bags') or ($a[3] != 'contain')) {
                throw new \Exception('Invalid input');
            }
            $bag = $a[0] . ' ' . $a[1];
            $this->contains[$bag] = [];
            if ((count($a) == 7) and ($a[4] == 'no') and ($a[5] == 'other') and ($a[6] == 'bags.')) {
                continue;
            }
            if (count($a) % 4 != 0) {
                throw new \Exception('Invalid input');
            }
            for ($i = 1; $i < intdiv(count($a), 4); ++$i) {
                if (!is_numeric($a[4 * $i]) or !in_array($a[4 * $i + 3], ['bag,', 'bags,', 'bag.', 'bags.'])) {
                    throw new \Exception('Invalid input');
                }
                $innerBag = $a[4 * $i + 1] . ' ' . $a[4 * $i + 2];
                $this->contains[$bag][$innerBag] = intval($a[4 * $i]);
                if (!isset($this->containedBy[$innerBag])) {
                    $this->containedBy[$innerBag] = [];
                }
                $this->containedBy[$innerBag][] = $bag;
            }
        }
    }

    public function getSumContainerBags(string $bag): int
    {
        $bags = [];
        $q = [$bag];
        while (count($q) > 0) {
            $currentBag = array_shift($q);
            foreach ($this->containedBy[$currentBag] ?? [] as $containerBag) {
                if (isset($bags[$containerBag])) {
                    continue;
                }
                $bags[$containerBag] = true;
                $q[] = $containerBag;
            }
        }
        return count($bags);
    }

    public function getSumContainedBags(string $bag): int
    {
        if (isset($this->memo[$bag])) {
            return $this->memo[$bag];
        }
        $ans = 0;
        foreach ($this->contains[$bag] ?? [] as $containedBag => $count) {
            $ans += $count * ($this->getSumContainedBags($containedBag) + 1);
        }
        $this->memo[$bag] = $ans;
        return $ans;
    }
}
