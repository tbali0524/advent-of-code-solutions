<?php

declare(strict_types=1);

namespace TBali\Aoc2024;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2024 Day 23: LAN Party.
 *
 * @see https://adventofcode.com/2024/day/23
 */
final class Aoc2024Day23 extends SolutionBase
{
    public const YEAR = 2024;
    public const DAY = 23;
    public const TITLE = 'LAN Party';
    public const SOLUTIONS = [1200, 'ag,gh,hh,iv,jx,nq,oc,qm,rb,sm,vm,wu,zr'];
    public const EXAMPLE_SOLUTIONS = [[7, 'co,de,ka,ta']];

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
        $vertices = [];
        $edges = [];
        foreach ($input as $row) {
            if (strlen($row) != 5) {
                throw new \Exception('input lines must have 5 chars');
            }
            $v1 = substr($row, 0, 2);
            $v2 = substr($row, 3, 2);
            $vertices[$v1] = true;
            $vertices[$v2] = true;
            $edges[$v1][$v2] = true;
            $edges[$v2][$v1] = true;
        }
        // ---------- Part 1
        $ans1 = 0;
        foreach ($edges as $v1 => $adj_set) {
            foreach (array_keys($adj_set) as $v2) {
                foreach (array_keys($adj_set) as $v3) {
                    if ($v2 == $v3) {
                        continue;
                    }
                    if (($v1[0] != 't') and ($v2[0] != 't') and ($v3[0] != 't')) {
                        continue;
                    }
                    if (!isset($edges[$v2][$v3])) {
                        continue;
                    }
                    ++$ans1;
                }
            }
        }
        $ans1 = intdiv($ans1, 6);
        // ---------- Part 2
        $r = [];
        $p = $vertices;
        $x = [];
        $maximal_cliques = [];
        self::bronKerbosch1($maximal_cliques, $edges, $r, $p, $x);
        usort($maximal_cliques, static fn (array $a, array $b) => count($b) <=> count($a));
        $result = $maximal_cliques[0] ?: [];
        sort($result);
        $ans2 = implode(',', $result);
        return [strval($ans1), $ans2];
    }

    /**
     * Find all maximal cliques in a graph.
     *
     * @see <https://https://en.wikipedia.org/wiki/Bron%E2%80%93Kerbosch_algorithm>
     *
     * @param array<int, array<int, string>>     $maximal_cliques
     * @param array<string, array<string, bool>> $edges
     * @param array<string, bool>                $r
     * @param array<string, bool>                $p
     * @param array<string, bool>                $x
     */
    private function bronKerbosch1(&$maximal_cliques, $edges, $r, $p, $x): void
    {
        if ((count($p) == 0) and (count($x) == 0)) {
            $maximal_cliques[] = array_keys($r);
        }
        $p1 = $p;
        $x1 = $x;
        foreach (array_keys($p) as $v) {
            $nb = $edges[$v];
            $r2 = $r;
            $r2[$v] = true;
            $p2 = [];
            $x2 = [];
            foreach (array_keys($edges[$v]) as $nb) {
                if (isset($p1[$nb])) {
                    $p2[$nb] = true;
                }
                if (isset($x1[$nb])) {
                    $x2[$nb] = true;
                }
            }
            self::bronKerbosch1($maximal_cliques, $edges, $r2, $p2, $x2);
            unset($p1[$v]);
            $x1[$v] = true;
        }
    }
}
