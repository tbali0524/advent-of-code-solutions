<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2025;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2025 Day 10: Factory.
 *
 * @see https://adventofcode.com/2025/day/10
 */
final class Aoc2025Day10 extends SolutionBase
{
    public const YEAR = 2025;
    public const DAY = 10;
    public const TITLE = 'Factory';
    public const SOLUTIONS = [509, 0]; // part 2: 6616
    public const EXAMPLE_SOLUTIONS = [[7, 0]]; // part 2: 33

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
        $machines = [];
        foreach ($input as $line) {
            $machines[] = Machine::fromString($line);
        }
        // ---------- Part 1
        $ans1 = 0;
        foreach ($machines as $machine) {
            $ans1 += $machine->solvePart1();
        }
        // ---------- Part 2
        $ans2 = 0;
        return [strval($ans1), strval($ans2)];
    }
}

class Machine
{
    public int $targetBitmap = 0;
    /** @var array<int, int> */
    public array $buttonBitmaps = [];
    /** @var array<int, array<int, int>> */
    public array $buttons = [];
    /** @var array<int, int> */
    public array $joltages = [];

    public function solvePart1(): int
    {
        $q = [[0, 0]];
        $visited = [0 => true];
        $idx_read = 0;
        while ($idx_read < count($q)) {
            [$state, $step] = $q[$idx_read];
            /** @var int $state */
            /** @var int $step */
            ++$idx_read;
            if ($state == $this->targetBitmap) {
                return $step;
            }
            foreach ($this->buttonBitmaps as $button_bitmap) {
                $next_state = $state ^ $button_bitmap;
                if (isset($visited[$next_state])) {
                    continue;
                }
                $visited[$next_state] = true;
                $q[] = [$next_state, $step + 1];
            }
        }
        return 0;
    }

    public static function fromString(string $line): self
    {
        $m = new self();
        $a = explode(' ', $line);
        if (
            count($a) < 3
            || strlen($a[0]) < 3
            || !str_starts_with($a[0], '[')
            || !str_ends_with($a[0], ']')
            || strlen($a[count($a) - 1]) < 3
            || !str_starts_with($a[count($a) - 1], '{')
            || !str_ends_with($a[count($a) - 1], '}')
        ) {
            throw new \Exception('Invalid input');
        }
        for ($bit_pos = 0; $bit_pos < strlen($a[0]) - 2; ++$bit_pos) {
            $m->targetBitmap |= match ($a[0][1 + $bit_pos]) {
                '#' => 1 << $bit_pos,
                '.' => 0,
                default => throw new \Exception('Invalid input'),
            };
        }
        for ($i = 1; $i < count($a) - 1; ++$i) {
            if (
                strlen($a[$i]) < 3
                || !str_starts_with($a[$i], '(')
                || !str_ends_with($a[$i], ')')
            ) {
                throw new \Exception('Invalid input');
            }
            $button = array_map(intval(...), explode(',', substr($a[$i], 1, -1)));
            $wiring = 0;
            foreach ($button as $pos) {
                $wiring |= 1 << $pos;
            }
            $m->buttonBitmaps[] = $wiring;
            $m->buttons[] = $button;
        }
        $m->joltages = array_map(intval(...), explode(',', substr($a[count($a) - 1], 1, -1)));
        return $m;
    }
}
