<?php

declare(strict_types=1);

namespace TBali\Aoc2020;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2020 Day 4: Passport Processing.
 *
 * Part 1: In your batch file, how many passports are valid?
 * Part 2: Count the number of valid passports - those that have all required fields and valid values.
 *         Continue to treat cid as optional. In your batch file, how many passports are valid?
 *
 * Topics: input parsing, object validation
 *
 * @see https://adventofcode.com/2020/day/4
 */
final class Aoc2020Day04 extends SolutionBase
{
    public const YEAR = 2020;
    public const DAY = 4;
    public const TITLE = 'Passport Processing';
    public const SOLUTIONS = [245, 133];
    public const EXAMPLE_SOLUTIONS = [[2, 0], [0, 4]];

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
        $passports = $this->parseInput($input);
        // ---------- Part 1
        $ans1 = count(array_filter(
            $passports,
            fn (array $x): bool => count($x) >= 7 + (isset($x['cid']) ? 1 : 0)
        ));
        // ---------- Part 2
        $ans2 = 0;
        foreach ($passports as $passport) {
            if (count($passport) < 7 + (isset($passport['cid']) ? 1 : 0)) {
                continue;
            }
            $isOk = true;
            foreach ($passport as $key => $v) {
                $isOk = match ($key) {
                    'byr' => intval($v) >= 1920 && intval($v) <= 2002,
                    'iyr' => intval($v) >= 2010 && intval($v) <= 2020,
                    'eyr' => intval($v) >= 2020 && intval($v) <= 2030,
                    'hgt' => match (substr($v, -2)) {
                        'cm' => intval(substr($v, 0, -2)) >= 150 && intval(substr($v, 0, -2)) <= 193,
                        'in' => intval(substr($v, 0, -2)) >= 59 && intval(substr($v, 0, -2)) <= 76,
                        default => false
                    },
                    'hcl' => strlen($v) == 7 && $v[0] == '#' && ctype_xdigit(substr($v, 1)),
                    'ecl' => in_array($v, ['amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth']),
                    'pid' => strlen($v) == 9 && ctype_digit($v),
                    'cid' => true,
                    // @codeCoverageIgnoreStart
                    default => false,
                    // @codeCoverageIgnoreEnd
                };
                if (!$isOk) {
                    break;
                }
            }
            if ($isOk) {
                ++$ans2;
            }
        }
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<int, string> $input
     *
     * @return array<int, array<string, string>>
     */
    private function parseInput(array $input): array
    {
        $passports = [];
        $passport = [];
        foreach ($input as $line) {
            if ($line == '') {
                $passports[] = $passport;
                $passport = [];
                continue;
            }
            $items = explode(' ', $line);
            foreach ($items as $item) {
                $b = explode(':', $item);
                if (count($b) != 2) {
                    throw new \Exception('Invalid input');
                }
                $passport[$b[0]] = $b[1];
            }
        }
        if ($passport != []) {
            $passports[] = $passport;
        }
        return $passports;
    }
}
