<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 9: Marble Mania.
 *
 * Part 1: What is the winning Elf's score?
 * Part 2: What would the new winning Elf's score be if the number of the last marble were 100 times larger?
 *
 * Topics: circular linked list
 *
 * @see https://adventofcode.com/2018/day/9
 */
final class Aoc2018Day09 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 9;
    public const TITLE = 'Marble Mania';
    public const SOLUTIONS = [429943, 3615691746];
    public const EXAMPLE_SOLUTIONS = [[32, 0], [8317, 0], [146373, 0], [2764, 0], [54718, 0], [37305, 0]];

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
        $a = explode(' ', $input[0] ?? '');
        $countPlayers = intval($a[0] ?? '0');
        $lastMarble = intval($a[6] ?? '0');
        // ---------- Part 1 + 2
        $part2multiplier = $lastMarble > 10_000 ? 100 : 1;
        $scores = array_fill(0, $countPlayers, 0);
        $current = ListItem::init();
        $player = 0;
        $ans1 = 0;
        for ($marble = 1; $marble <= $part2multiplier * $lastMarble; ++$marble) {
            if ($marble % 23 != 0) {
                $current = $current->next;
                $current = $current->insertRight($marble);
            } else {
                $current = $current->nth(-5);
                $value = $current->removeLeft();
                $scores[$player] += $marble + $value;
            }
            $player = ($player + 1) % $countPlayers;
            if ($marble == $lastMarble) {
                $ans1 = intval(max($scores));
            }
        }
        $ans2 = intval(max($scores));
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class ListItem
{
    public ListItem $prev;
    public ListItem $next;

    public function __construct(
        public readonly int $value,
    ) {
    }

    public function insertRight(int $value): self
    {
        $item = new self($value);
        $item->next = $this->next;
        $item->prev = $this;
        $this->next = $item;
        $item->next->prev = $item;
        return $item;
    }

    public function removeLeft(): int
    {
        $value = $this->prev->value;
        $this->prev->prev->next = $this;
        $this->prev = $this->prev->prev;
        return $value;
    }

    /**
     * Get the item off by $delta positions (left or right).
     */
    public function nth(int $delta): ListItem
    {
        $ans = $this;
        if ($delta >= 0) {
            while ($delta > 0) {
                $ans = $ans->next;
                --$delta;
            }
        } else {
            $delta = -$delta + 1;
            while ($delta > 0) {
                $ans = $ans->prev;
                --$delta;
            }
        }
        return $ans;
    }

    public static function init(): self
    {
        $item = new ListItem(0);
        $item->prev = $item;
        $item->next = $item;
        return $item;
    }

    /**
     * @codeCoverageIgnore
     */
    public function printList(): void
    {
        $item = $this;
        $a = [];
        while (true) {
            $a[] = $item->value;
            $item = $item->next;
            if ($item === $this) {
                break;
            }
        }
        echo implode(', ', $a), PHP_EOL;
    }
}
