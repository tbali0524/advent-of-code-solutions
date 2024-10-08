<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2020 Day 16: Ticket Translation.
 *
 * Part 1: Consider the validity of the nearby tickets you scanned. What is your ticket scanning error rate?
 * Part 2: Once you work out which field is which, look for the six fields on your ticket
 *         that start with the word departure. What do you get if you multiply those six values together?
 *
 * Topics: input parsing, object validation
 *
 * @see https://adventofcode.com/2020/day/16
 */
final class Aoc2020Day16 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 16;
    public const TITLE = 'Ticket Translation';
    public const SOLUTIONS = [27870, 3173135507987];
    public const EXAMPLE_SOLUTIONS = [[71, 0], [0, 156]];

    /** @var FieldValidator[] */
    private array $validators = [];
    /** @var array<int, int> */
    private array $myTicket = [];
    /** @var array<int, array<int, int>> */
    private array $nearbyTickets = [];

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
        $this->parseInput($input);
        // ---------- Part 1 + prepare for  Part 2
        $ans1 = 0;
        $validTickets = [];
        foreach ($this->nearbyTickets as $ticket) {
            $isTicketOk = true;
            foreach ($ticket as $value) {
                $isOk = false;
                foreach ($this->validators as $validator) {
                    if ($validator->validate($value)) {
                        $isOk = true;
                        break;
                    }
                }
                if (!$isOk) {
                    $isTicketOk = false;
                    $ans1 += $value;
                }
            }
            if ($isTicketOk) {
                $validTickets[] = $ticket;
            }
        }
        // ---------- Part 2
        $posValidFields = [];
        for ($idxPos = 0; $idxPos < count($this->myTicket); ++$idxPos) {
            $valuesAtPos = array_map(
                static fn (array $ticket): int => $ticket[$idxPos],
                $validTickets
            );
            $posValidFields[$idxPos] = [];
            foreach ($this->validators as $idxField => $validator) {
                if ($validator->validateArray($valuesAtPos)) {
                    $posValidFields[$idxPos][$idxField] = true;
                }
            }
        }
        $posToFieldMap = [];
        while (true) {
            if (count($posValidFields) == 0) {
                break;
            }
            uasort($posValidFields, static fn (array $a, array $b): int => count($a) <=> count($b));
            $idxPos = array_key_first($posValidFields);
            if (count($posValidFields[$idxPos]) != 1) {
                // @codeCoverageIgnoreStart
                throw new \Exception('No solution found');
                // @codeCoverageIgnoreEnd
            }
            $idxField = array_key_first($posValidFields[$idxPos]);
            $posToFieldMap[$idxPos] = $idxField;
            foreach ($posValidFields as $idx => $arr) {
                unset($posValidFields[$idx][$idxField]);
            }
            unset($posValidFields[$idxPos]);
        }
        $ans2 = 1;
        for ($idxPos = 0; $idxPos < count($this->myTicket); ++$idxPos) {
            if (str_contains($this->validators[$posToFieldMap[$idxPos]]->name, 'departure')) {
                $ans2 *= $this->myTicket[$idxPos];
            }
        }
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, string> $input
     */
    private function parseInput(array $input): void
    {
        $this->validators = [];
        // validators section
        $idxLine = 0;
        while ($idxLine < count($input)) {
            $line = $input[$idxLine];
            if ($line == '') {
                ++$idxLine;
                break;
            }
            $a = explode(': ', $line);
            if (count($a) != 2) {
                throw new \Exception('Invalid input');
            }
            $b = explode(' or ', $a[1]);
            if (count($b) != 2) {
                // @codeCoverageIgnoreStart
                throw new \Exception('Invalid input');
                // @codeCoverageIgnoreEnd
            }
            $c = explode('-', $b[0]);
            $d = explode('-', $b[1]);
            if ((count($c) != 2) or (count($d) != 2)) {
                // @codeCoverageIgnoreStart
                throw new \Exception('Invalid input');
                // @codeCoverageIgnoreEnd
            }
            $this->validators[] = new FieldValidator(
                name: $a[0],
                min1: intval($c[0]),
                max1: intval($c[1]),
                min2: intval($d[0]),
                max2: intval($d[1]),
            );
            ++$idxLine;
        }
        // my and nearby tickets sections
        if (
            ($idxLine > count($input) - 5)
            or ($input[$idxLine] != 'your ticket:')
            or ($input[$idxLine + 2] != '')
            or ($input[$idxLine + 3] != 'nearby tickets:')
        ) {
            // @codeCoverageIgnoreStart
            throw new \Exception('Invalid input');
            // @codeCoverageIgnoreEnd
        }
        $this->myTicket = array_map(intval(...), explode(',', $input[$idxLine + 1]));
        if (count($this->myTicket) != count($this->validators)) {
            // @codeCoverageIgnoreStart
            throw new \Exception('Invalid input');
            // @codeCoverageIgnoreEnd
        }
        $this->nearbyTickets = [];
        $idxLine += 4;
        while ($idxLine < count($input)) {
            $ticket = array_map(intval(...), explode(',', $input[$idxLine]));
            if (count($ticket) != count($this->validators)) {
                // @codeCoverageIgnoreStart
                throw new \Exception('Invalid input');
                // @codeCoverageIgnoreEnd
            }
            $this->nearbyTickets[] = $ticket;
            ++$idxLine;
        }
    }
}

// --------------------------------------------------------------------
final class FieldValidator
{
    public function __construct(
        public readonly string $name,
        public readonly int $min1,
        public readonly int $max1,
        public readonly int $min2,
        public readonly int $max2,
    ) {
    }

    public function validate(int $n): bool
    {
        return ($n >= $this->min1 && $n <= $this->max1) || ($n >= $this->min2 && $n <= $this->max2);
    }

    /** @param array<int, int> $a */
    public function validateArray(array $a): bool
    {
        foreach ($a as $value) {
            if (!$this->validate($value)) {
                return false;
            }
        }
        return true;
    }
}
