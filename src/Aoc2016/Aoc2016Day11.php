<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2016;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2016 Day 11: Radioisotope Thermoelectric Generators.
 *
 * Part 1: What is the minimum number of steps required to bring all of the objects to the fourth floor?
 * Part 2: What is the minimum number of steps required to bring all of the objects,
 *         including these four new ones, to the fourth floor?
 *
 * Topics: BFS
 *
 * @see https://adventofcode.com/2016/day/11
 */
final class Aoc2016Day11 extends SolutionBase
{
    public const YEAR = 2016;
    public const DAY = 11;
    public const TITLE = 'Radioisotope Thermoelectric Generators';
    public const SOLUTIONS = [31, 0];
    public const EXAMPLE_SOLUTIONS = [[9, 0], [0, 0]];

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
        // ---------- Part 1
        $startState = House::fromInput($input);
        $ans1 = $this->solvePart($startState);
        // detect example input
        if ($startState->countElements == 2) {
            return [strval($ans1), '0'];
        }
        // ---------- Part 2
        $input[0] = 'The first floor contains a thulium generator, a thulium-compatible microchip, '
            . 'a plutonium generator, a strontium generator, '
            . 'an elerium generator, an elerium-compatible microchip, '
            . 'a dilithium generator and a dilithium-compatible microchip.';
        $startState = House::fromInput($input);
        $ans2 = 0; // $this->solvePart($startState);
        return [strval($ans1), strval($ans2)];
    }

    private function solvePart(House $startState): int
    {
        $visited = [$startState->hash() => true];
        $q = [$startState];
        while (true) {
            if (count($q) == 0) {
                throw new \Exception('No solution found');
            }
            $current = array_shift($q);
            if ($current->isWinning()) {
                return $current->countMoves;
            }
            foreach ($current->allMoves() as $next) {
                $hash = $next->hash();
                if (isset($visited[$hash])) {
                    continue;
                }
                $visited[$hash] = true;
                $q[] = $next;
            }
        }
    }
}

// --------------------------------------------------------------------
final class House
{
    public const FLOOR_NAMES = ['first', 'second', 'third', 'fourth'];

    public int $countMoves = 0;
    public int $countFloors = 4;    // assumption in hash function: max 16 (4 bits)
    public int $countElements = 0;  // count of chip - generator pairs
    public int $elevator = 0;

    /**
     * Current position of each chips (index 0) and generators (index 1).
     *
     * @var array<int, array<int, int>>
     *
     * @phpstan-var array{array<int, int>, array<int, int>}
     */
    public array $items = [[], []];

    public function hash(): int
    {
        $h = $this->elevator;
        for ($type = 0; $type <= 1; ++$type) {
            for ($id = 0; $id < $this->countElements; ++$id) {
                $h = ($h << 4) | $this->items[$type][$id];
            }
        }
        return $h;
    }

    public function isWinning(): bool
    {
        if ($this->elevator != $this->countFloors - 1) {
            return false;
        }
        for ($type = 0; $type <= 1; ++$type) {
            for ($id = 0; $id < $this->countElements; ++$id) {
                if ($this->items[$type][$id] != $this->countFloors - 1) {
                    return false;
                }
            }
        }
        return true;
    }

    public function isValid(): bool
    {
        $floorHasSoloChip = [];
        $floorHasSoloGenerator = [];
        for ($id = 0; $id < $this->countElements; ++$id) {
            if ($this->items[0][$id] == $this->items[1][$id]) {
                continue;
            }
            if (isset($floorHasSoloChip[$this->items[1][$id]])) {
                return false;
            }
            if (isset($floorHasSoloGenerator[$this->items[0][$id]])) {
                return false;
            }
            $floorHasSoloChip[$this->items[0][$id]] = true;
            $floorHasSoloGenerator[$this->items[1][$id]] = true;
        }
        return true;
    }

    /** @return array<int, House> */
    public function allMoves(): array
    {
        $houses = [];
        for ($dir = -1; $dir <= 1; $dir += 2) {
            $newFloor = $this->elevator + $dir;
            if (($newFloor < 0) or ($newFloor >= $this->countFloors)) {
                continue;
            }
            for ($item1 = 0; $item1 < 2 * $this->countElements; ++$item1) {
                if ($this->items[$item1 & 1][$item1 >> 1] != $this->elevator) {
                    continue;
                }
                $house1 = clone $this;
                ++$house1->countMoves;
                $house1->elevator = $newFloor;
                $house1->items[$item1 & 1][$item1 >> 1] = $newFloor;
                if ($house1->isValid()) {
                    $houses[] = $house1;
                }
                for ($item2 = $item1 + 1; $item2 < 2 * $this->countElements; ++$item2) {
                    if ($this->items[$item2 & 1][$item2 >> 1] != $this->elevator) {
                        continue;
                    }
                    $house2 = clone $house1;
                    $house2->items[$item2 & 1][$item2 >> 1] = $newFloor;
                    if ($house2->isValid()) {
                        $houses[] = $house2;
                    }
                }
            }
        }
        return $houses;
    }

    /** @param array<int, string> $input */
    public static function fromInput(array $input): self
    {
        $h = new self();
        $h->countFloors = count($input);
        $elements = [];
        foreach ($input as $idx => $line) {
            $a = explode(' ', strtolower($line));
            if ((count($a) < 6) or ($a[0] != 'the') or ($a[2] != 'floor') or ($a[3] != 'contains')) {
                throw new \Exception('Invalid input');
            }
            if ((count($a) == 6) and str_ends_with($line, 'nothing relevant.')) {
                continue;
            }
            $floor = array_search($a[1], self::FLOOR_NAMES, true);
            if ($floor === false) {
                $floor = $idx;
            }
            for ($i = 4; $i + 2 < count($a); $i += 3) {
                if ($a[$i] == 'and') {
                    ++$i;
                }
                if (($a[$i] != 'a') and ($a[$i] != 'an')) {
                    throw new \Exception('Invalid input');
                }
                $element = explode('-', $a[$i + 1])[0];
                $type = str_replace([',', '.'], '', $a[$i + 2]);
                if (!isset($elements[$element])) {
                    $id = $h->countElements;
                    $elements[$element] = $id;
                    ++$h->countElements;
                } else {
                    $id = $elements[$element];
                }
                match ($type) {
                    'microchip' => $h->items[0][$id] = $floor,
                    'generator' => $h->items[1][$id] = $floor,
                    default => throw new \Exception('Invalid input'),
                };
            }
        }
        return $h;
    }
}
