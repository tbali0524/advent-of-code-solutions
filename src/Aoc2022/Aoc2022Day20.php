<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2022;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2022 Day 20: Grove Positioning System.
 *
 * Part 1: Mix your encrypted file exactly once. What is the sum of the three numbers that form the grove coordinates?
 * Part 2: Apply the decryption key and mix your encrypted file ten times.
 *         What is the sum of the three numbers that form the grove coordinates?
 *
 * Topics: circular linked list
 *
 * @see https://adventofcode.com/2022/day/20
 */
final class Aoc2022Day20 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 20;
    public const TITLE = 'Grove Positioning System';
    public const SOLUTIONS = [2203, 6641234038999];
    public const EXAMPLE_SOLUTIONS = [[3, 1623178306]];

    private const MULTIPLIER_PART2 = 811589153;
    private const COUNT_MIX_PART2 = 10;

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
        /** @var array<int, int> */
        $data = array_map(intval(...), $input);
        // ---------- Part 1
        $listItems = $this->createList($data);
        $zeroItem = $this->getZeroItem($listItems);
        $this->mix($listItems, 1);
        $ans1 = $this->getCoord($zeroItem, count($listItems));
        // ---------- Part 2
        $listItems = $this->createList($data, self::MULTIPLIER_PART2);
        $zeroItem = $this->getZeroItem($listItems);
        $this->mix($listItems, self::COUNT_MIX_PART2);
        $ans2 = $this->getCoord($zeroItem, count($listItems));
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, int> $data
     *
     * @return array<int, ListItem>
     */
    private function createList(array $data, int $multiplier = 1): array
    {
        $listItems = [];
        foreach ($data as $pos => $value) {
            $listItems[] = new ListItem($pos, $value * $multiplier);
        }
        for ($i = 0; $i < count($listItems); ++$i) {
            $listItems[$i]->prev = $listItems[($i - 1 + count($listItems)) % count($listItems)];
            $listItems[$i]->next = $listItems[($i + 1) % count($listItems)];
        }
        return $listItems;
    }

    /**
     * @param array<int, ListItem> $listItems
     */
    private function getZeroItem(array $listItems): ListItem
    {
        foreach ($listItems as $listItem) {
            if ($listItem->value == 0) {
                return $listItem;
            }
        }
        throw new \Exception('Invalid input');
    }

    /**
     * @param array<int, ListItem> $listItems
     */
    private function mix(array $listItems, int $count = 1): void
    {
        for ($i = 0; $i < $count; ++$i) {
            foreach ($listItems as $listItem) {
                $moveBy = $listItem->value % (count($listItems) - 1);
                if ($moveBy == 0) {
                    continue;
                }
                $nthItem = $listItem->nth($moveBy);
                $listItem->prev->next = $listItem->next;
                $listItem->next->prev = $listItem->prev;
                $listItem->next = $nthItem->next;
                $nthItem->next->prev = $listItem;
                $listItem->prev = $nthItem;
                $nthItem->next = $listItem;
            }
        }
    }

    private function getCoord(ListItem $zeroItem, int $modulus): int
    {
        return $zeroItem->nth(1000 % $modulus)->value
            + $zeroItem->nth(2000 % $modulus)->value
            + $zeroItem->nth(3000 % $modulus)->value;
    }
}

// --------------------------------------------------------------------
final class ListItem
{
    public ListItem $prev;
    public ListItem $next;

    public function __construct(
        public readonly int $startPos,
        public readonly int $value,
    ) {
    }

    /**
     * Get the item off by $delta positions (left or right).
     */
    public function nth(int $delta): self
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
