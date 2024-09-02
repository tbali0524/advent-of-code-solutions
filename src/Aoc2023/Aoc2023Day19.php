<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

declare(strict_types=1);

namespace TBali\Aoc2023;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2023 Day 19: Aplenty.
 *
 * Part 1: What do you get if you add together all of the rating numbers for all of the parts
 *         that ultimately get accepted?
 * Part 2: How many distinct combinations of ratings will be accepted by the Elves' workflows?
 *
 * @see https://adventofcode.com/2023/day/19
 */
final class Aoc2023Day19 extends SolutionBase
{
    public const YEAR = 2023;
    public const DAY = 19;
    public const TITLE = 'Aplenty';
    public const SOLUTIONS = [432434, 132557544578569];
    public const EXAMPLE_SOLUTIONS = [[19114, 167409079868000]];

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
        $workflows = [];
        $parts = [];
        $i = 0;
        while (($i < count($input)) and ($input[$i] != '')) {
            $w = Workflow::fromString($input[$i]);
            $workflows[$w->name] = $w;
            ++$i;
        }
        ++$i;
        while ($i < count($input)) {
            $parts[] = Part::fromString($input[$i]);
            ++$i;
        }
        if ((count($workflows) == 0) or (count($parts) == 0)) {
            throw new \Exception('Invalid input');
        }
        // ---------- Part 1
        $ans1 = 0;
        foreach ($parts as $part) {
            $wfName = 'in';
            while (true) {
                $wf = $workflows[$wfName] ?? throw new \Exception('Invalid input');
                $wfName = $wf->nextWorkflow($part);
                if ($wfName == Workflow::ACCEPTED) {
                    $ans1 += $part->rating();
                    break;
                }
                if ($wfName == Workflow::REJECTED) {
                    break;
                }
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        $q = [['in', new PartRange()]];
        $idxRead = 0;
        while (true) {
            if ($idxRead >= count($q)) {
                break;
            }
            [$wfName, $range] = $q[$idxRead];
            ++$idxRead;
            $wf = $workflows[$wfName];
            $nextList = $wf->nextWorkflowRanges($range);
            foreach ($nextList as [$nextWfName, $nextRange]) {
                if ($nextWfName == Workflow::ACCEPTED) {
                    $ans2 += $nextRange->countParts();
                } elseif ($nextWfName != Workflow::REJECTED) {
                    $q[] = [$nextWfName, $nextRange];
                }
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}

// --------------------------------------------------------------------
final class Workflow
{
    public const ACCEPTED = 'A';
    public const REJECTED = 'R';

    public string $name = '';
    /** @var array <int, string> */
    public array $properties = [];
    /** @var array <int, string> */
    public array $conditions = [];
    /** @var array <int, int> */
    public array $values = [];
    /** @var array <int, string> */
    public array $nextWorkflows = [];
    public string $defaultWorkflow = '';

    public function nextWorkflow(Part $p): string
    {
        for ($i = 0; $i < count($this->properties); ++$i) {
            if (
                (($this->conditions[$i] == '<') and ($p->properties[$this->properties[$i]] < $this->values[$i]))
                or (($this->conditions[$i] == '>') and ($p->properties[$this->properties[$i]] > $this->values[$i]))
            ) {
                return $this->nextWorkflows[$i];
            }
        }
        return $this->defaultWorkflow;
    }

    /**
     * @phpstan-return array<int, array{string, PartRange}>
     */
    public function nextWorkflowRanges(PartRange $range): array
    {
        $ans = [];
        $r = $range;
        for ($i = 0; $i < count($this->properties); ++$i) {
            $property = $this->properties[$i];
            $min = $r->min[$property];
            $max = $r->max[$property];
            $value = $this->values[$i];
            $next = $this->nextWorkflows[$i];
            if ($this->conditions[$i] == '<') {
                if ($max < $value) {
                    $ans[] = [$next, clone $r];
                    return $ans;
                }
                if ($value <= $min) {
                    continue;
                }
                $low = clone $r;
                $low->max[$property] = $value - 1;
                $high = clone $r;
                $high->min[$property] = $value;
                $ans[] = [$next, $low];
                $r = $high;
                continue;
            }
            if ($this->conditions[$i] == '>') {
                if ($value < $min) {
                    $ans[] = [$next, clone $r];
                    return $ans;
                }
                if ($max <= $value) {
                    continue;
                }
                $low = clone $r;
                $low->max[$property] = $value;
                $high = clone $r;
                $high->min[$property] = $value + 1;
                $ans[] = [$next, $high];
                $r = $low;
                continue;
            }
        }
        $ans[] = [$this->defaultWorkflow, $r];
        return $ans;
    }

    public static function fromString(string $s): self
    {
        $a = explode('{', $s);
        if ((count($a) != 2) or ($s[-1] != '}')) {
            throw new \Exception('Invalid input');
        }
        $w = new self();
        $w->name = $a[0];
        $rules = explode(',', substr($a[1], 0, -1));
        foreach ($rules as $idx => $rule) {
            if ($idx == count($rules) - 1) {
                $w->defaultWorkflow = $rule;
                break;
            }
            $b = explode(':', $rule);
            if (
                (count($b) != 2) or (strlen($b[0]) < 3)
                or !str_contains('xmas', $b[0][0]) or !str_contains('<>', $b[0][1])
            ) {
                throw new \Exception('Invalid input');
            }
            $w->properties[] = $b[0][0];
            $w->conditions[] = $b[0][1];
            $w->values[] = intval(substr($b[0], 2));
            $w->nextWorkflows[] = $b[1];
        }
        return $w;
    }
}

// --------------------------------------------------------------------
final class Part
{
    /** @var array<string, int> */
    public array $properties = [];

    public function rating(): int
    {
        return intval(array_sum($this->properties));
    }

    public static function fromString(string $s): self
    {
        $count = sscanf($s, '{x=%d,m=%d,a=%d,s=%d}', $vx, $vm, $va, $vs);
        if ($count != 4) {
            throw new \Exception('Invalid input');
        }
        $p = new self();
        $p->properties = ['x' => intval($vx), 'm' => intval($vm), 'a' => intval($va), 's' => intval($vs)];
        return $p;
    }
}

// --------------------------------------------------------------------
final class PartRange
{
    public const MIN_PROPERTY = 1;
    public const MAX_PROPERTY = 4000;

    /** @var array<string, int> */
    public array $min = [
        'x' => self::MIN_PROPERTY,
        'm' => self::MIN_PROPERTY,
        'a' => self::MIN_PROPERTY,
        's' => self::MIN_PROPERTY,
    ];
    /** @var array<string, int> */
    public array $max = [
        'x' => self::MAX_PROPERTY,
        'm' => self::MAX_PROPERTY,
        'a' => self::MAX_PROPERTY,
        's' => self::MAX_PROPERTY,
    ];

    public function countParts(): int
    {
        $ans = 1;
        foreach ($this->min as $property => $min) {
            $ans *= $this->max[$property] - $min + 1;
        }
        return $ans;
    }
}
