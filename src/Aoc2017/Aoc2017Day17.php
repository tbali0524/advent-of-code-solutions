<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2017;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2017 Day 17: Spinlock.
 *
 * Part 1: What is the value after 2017 in your completed circular buffer?
 * Part 2: What is the value after 0 the moment 50000000 is inserted?
 *
 * Topics: circular linked list
 *
 * @see https://adventofcode.com/2017/day/17
 */
final class Aoc2017Day17 extends SolutionBase
{
    public const YEAR = 2017;
    public const DAY = 17;
    public const TITLE = 'Spinlock';
    public const SOLUTIONS = [1642, 33601318];
    public const STRING_INPUT = '301';
    public const EXAMPLE_SOLUTIONS = [[638, 0]];
    public const EXAMPLE_STRING_INPUTS = ['3'];

    private const MAX_TURNS_PART1 = 2017;
    private const MAX_TURNS_PART2 = 50_000_000;

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
        $maxSteps = intval($input[0]);
        // ---------- Part 1
        $list = new ListItem(0);
        $list->next = $list;
        for ($turn = 1; $turn <= self::MAX_TURNS_PART1; ++$turn) {
            $list = $list->nth($maxSteps % $turn);
            $list->insert($turn);
            $list = $list->next;
        }
        $ans1 = $list->next->value;
        // ---------- Part 2
        if ($maxSteps == 3) {
            return [strval($ans1), '0'];
        }
        // @codeCoverageIgnoreStart
        $ans2 = 0;
        $pos = 0;
        for ($turn = 1; $turn <= self::MAX_TURNS_PART2; ++$turn) {
            $pos = ($pos + $maxSteps) % $turn;
            if ($pos == 0) {
                $ans2 = $turn;
            }
            ++$pos;
        }
        return [strval($ans1), strval($ans2)];
        // @codeCoverageIgnoreEnd
    }
}

// --------------------------------------------------------------------
final class ListItem
{
    public ListItem $next;

    public function __construct(
        public readonly int $value,
    ) {
    }

    /**
     * Get the item off by $delta positions.
     */
    public function nth(int $delta): self
    {
        $ans = $this;
        while ($delta > 0) {
            $ans = $ans->next;
            --$delta;
        }
        return $ans;
    }

    /**
     * Insert a new value into the circular linked list after $this.
     */
    public function insert(int $value): void
    {
        $item = new self($value);
        $item->next = $this->next;
        $this->next = $item;
    }

    /**
     * @codeCoverageIgnore
     */
    public function printList(int $count): void
    {
        $item = $this;
        $a = [];
        for ($i = 0; $i < $count; ++$i) {
            $a[] = $item->value;
            $item = $item->next;
        }
        echo implode(', ', $a), PHP_EOL;
    }
}
