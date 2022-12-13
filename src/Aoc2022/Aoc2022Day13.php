<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2022;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2022 Day 13: Distress Signal.
 *
 * Part 1: Determine which pairs of packets are already in the right order.
 *         What is the sum of the indices of those pairs?
 * Part 2: Organize all of the packets into the correct order. What is the decoder key for the distress signal?
 *
 * @see https://adventofcode.com/2022/day/13
 *
 * @todo Part2
 */
final class Aoc2022Day13 extends SolutionBase
{
    public const YEAR = 2022;
    public const DAY = 13;
    public const TITLE = 'Distress Signal';
    public const SOLUTIONS = [5825, 24477];
    public const EXAMPLE_SOLUTIONS = [[13, 140], [0, 0]];

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
        $pairs = $this->parseInput($input);
        // ---------- Part 1
        $ans1 = 0;
        foreach ($pairs as $idx => $pair) {
            if (Item::compare($pair[0], $pair[1]) < 0) {
                $ans1 += $idx + 1;
            }
        }
        // ---------- Part 2
        $ans2 = 1;
        $items = [];
        foreach ($pairs as $pair) {
            foreach ($pair as $item) {
                $items[] = $item;
            }
        }
        $items[] = Item::fromString('[[2]]');
        $items[] = Item::fromString('[[6]]');
        usort($items, Item::compare(...));
        foreach ($items as $idx => $item) {
            if (($item->asString == '[[2]]') or ($item->asString == '[[6]]')) {
                $ans2 *= ($idx + 1);
            }
        }
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, string> $input The lines of the input, without LF
     *
     * @return array<int, array<int, Item>>
     *
     * @phpstan-return array<int, array{Item, Item}>
     */
    private function parseInput(array $input): array
    {
        $pairs = [];
        $countPairs = intdiv(count($input) + 1, 3);
        if (count($input) != $countPairs * 3 - 1) {
            throw new \Exception('Invalid input');
        }
        for ($i = 0; $i < $countPairs; ++$i) {
            if (($i != $countPairs - 1) and ($input[$i * 3 + 2] != '')) {
                throw new \Exception('Invalid input');
            }
            $pairs[] = [Item::fromString($input[$i * 3]), Item::fromString($input[$i * 3 + 1])];
        }
        return $pairs;
    }
}

// --------------------------------------------------------------------
final class Item
{
    public bool $isList = true;
    public int $value = 0;
    /** @var array<int, Item> */
    public array $items = [];
    public string $asString = '';

    /**
     * @codeCoverageIgnore
     */
    public static function fromInt(int $value): self
    {
        $item = new self();
        $item->isList = false;
        $item->value = $value;
        return $item;
    }

    public static function fromString(string $s): self
    {
        if (strlen($s) == 0) {
            throw new \Exception('Invalid input');
        }
        $item = new self();
        $item->asString = $s;
        if ($s[0] != '[') {
            $item->isList = false;
            $item->value = intval($s);
            return $item;
        }
        if ($s[strlen($s) - 1] != ']') {
            throw new \Exception('Invalid input');
        }
        $start = 1;
        $depth = 0;
        while ($start < strlen($s) - 1) {
            $end = $start;
            while ($end < strlen($s) - 1) {
                if ($s[$end] == '[') {
                    ++$depth;
                } elseif ($s[$end] == ']') {
                    --$depth;
                } elseif (($depth == 0) and ($s[$end] == ',')) {
                    break;
                }
                ++$end;
            }
            if ($depth != 0) {
                throw new \Exception('Invalid input');
            }
            $item->items[] = self::fromString(substr($s, $start, $end - $start));
            $start = $end + 1;
        }
        return $item;
    }

    public static function compare(Item $a, Item $b): int
    {
        if (!$a->isList and !$b->isList) {
            return $a->value <=> $b->value;
        }
        if ($a->isList and !$b->isList) {
            $temp = new self();
            $temp->items[] = $b;
            $b = $temp;
        } elseif (!$a->isList and $b->isList) {
            $temp = new self();
            $temp->items[] = $a;
            $a = $temp;
        }
        for ($i = 0; $i < min(count($a->items), count($b->items)); ++$i) {
            $result = self::compare($a->items[$i], $b->items[$i]);
            if ($result != 0) {
                return $result;
            }
        }
        return count($a->items) <=> count($b->items);
    }
}
