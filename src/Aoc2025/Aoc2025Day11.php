<?php

declare(strict_types=1);

namespace TBali\Aoc2025;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2025 Day 11: Reactor.
 *
 * @see https://adventofcode.com/2025/day/11
 */
final class Aoc2025Day11 extends SolutionBase
{
    public const YEAR = 2025;
    public const DAY = 11;
    public const TITLE = 'Reactor';
    public const SOLUTIONS = [428, 331468292364745];
    public const EXAMPLE_SOLUTIONS = [[5, 0], [0, 2]];

    /** @var array<string, int> */
    private array $memo = [];
    /** @var array<string, int> */
    private array $memo_d = [];
    /** @var array<string, int> */
    private array $memo_f = [];
    /** @var array<string, int> */
    private array $memo_df = [];

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
        $adj_list = [];
        $has_out = false;
        foreach ($input as $line) {
            $a = explode(' ', $line);
            if (!str_ends_with($a[0], ':')) {
                throw new \Exception('Invalid input');
            }
            $from = substr($a[0], 0, -1);
            $to = [];
            foreach (array_slice($a, 1) as $item) {
                if ($item == 'out') {
                    $has_out = true;
                }
                $to[] = $item;
            }
            $adj_list[$from] = $to;
        }
        if (!$has_out) {
            throw new \Exception('Invalid input');
        }
        // ---------- Part 1
        $ans1 = 0;
        $this->memo = [];
        if (isset($adj_list['you'])) {
            $ans1 = $this->countPathsPart1('you', $adj_list);
        }
        // ---------- Part 2
        $ans2 = 0;
        $this->memo = [];
        $this->memo_d = [];
        $this->memo_d = [];
        $this->memo_df = [];
        if (isset($adj_list['svr'])) {
            $ans2 = $this->countPathsPart2('svr', $adj_list);
        }
        return [strval($ans1), strval($ans2)];
    }

    /**
     * @param array<string, array<int, string>> $adj_list
     */
    private function countPathsPart1(string $from, array $adj_list): int
    {
        if ($from == 'out') {
            return 1;
        }
        if (isset($this->memo[$from])) {
            return $this->memo[$from];
        }
        $result = 0;
        foreach ($adj_list[$from] as $next) {
            $result += $this->countPathsPart1($next, $adj_list);
        }
        $this->memo[$from] = $result;
        return $result;
    }

    /**
     * @param array<string, array<int, string>> $adj_list
     */
    private function countPathsPart2(
        string $from,
        array $adj_list,
        bool $needs_dac = true,
        bool $needs_fft = true
    ): int {
        if ($from == 'out') {
            return $needs_dac || $needs_fft ? 0 : 1;
        }
        if (!$needs_dac && !$needs_fft && isset($this->memo[$from])) {
            return $this->memo[$from];
        }
        if ($needs_dac && !$needs_fft && isset($this->memo_d[$from])) {
            return $this->memo_d[$from];
        }
        if (!$needs_dac && $needs_fft && isset($this->memo_f[$from])) {
            return $this->memo_f[$from];
        }
        if ($needs_dac && $needs_fft && isset($this->memo_df[$from])) {
            return $this->memo_df[$from];
        }
        $current_dac = $from == 'dac';
        $current_fft = $from == 'fft';
        $result = 0;
        foreach ($adj_list[$from] as $next) {
            $result += $this->countPathsPart2(
                $next,
                $adj_list,
                $needs_dac && !$current_dac,
                $needs_fft && !$current_fft,
            );
        }
        if (!$needs_dac && !$needs_fft) {
            $this->memo[$from] = $result;
        } elseif ($needs_dac && !$needs_fft) {
            $this->memo_d[$from] = $result;
        // @phpstan-ignore booleanAnd.rightAlwaysTrue
        } elseif (!$needs_dac && $needs_fft) {
            $this->memo_f[$from] = $result;
        } elseif ($needs_dac && $needs_fft) {
            $this->memo_df[$from] = $result;
        }
        return $result;
    }
}
