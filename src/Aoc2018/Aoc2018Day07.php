<?php

declare(strict_types=1);

namespace TBali\Aoc2018;

use TBali\Aoc\SolutionBase;

/**
 * AoC 2018 Day 7: The Sum of Its Parts.
 *
 * Part 1: In what order should the steps in your instructions be completed?
 * Part 2: With 5 workers and the 60+ second step durations described above,
 *         how long will it take to complete all of the steps?
 *
 * Topics: Job scheduling
 *
 * @see https://adventofcode.com/2018/day/7
 */
final class Aoc2018Day07 extends SolutionBase
{
    public const YEAR = 2018;
    public const DAY = 7;
    public const TITLE = 'The Sum of Its Parts';
    public const SOLUTIONS = ['BKCJMSDVGHQRXFYZOAULPIEWTN', 1040];
    public const EXAMPLE_SOLUTIONS = [['CABDFE', 15]];

    private const MAX_WORKERS_EXAMPLE = 2;
    private const MAX_WORKERS_PART2 = 5;
    private const DURATION_BASE_EXAMPLE = 0;
    private const DURATION_BASE_PART2 = 60;

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
        $befores = [];
        $steps = [];
        // ---------- Parse input
        foreach ($input as $line) {
            $stepBefore = $line[5];
            $stepAfter = $line[36];
            $steps[$stepBefore] = true;
            $steps[$stepAfter] = true;
            $befores[$stepAfter][$stepBefore] = true;
        }
        /** @var array<int, string> */
        $steps = array_keys($steps);
        // ---------- Part 1
        $ans1 = '';
        $remainingBefores = $befores;
        while (true) {
            $possibleSteps = array_filter(
                $steps,
                static fn ($step) => count($remainingBefores[$step] ?? []) == 0 && !str_contains($ans1, $step),
            );
            sort($possibleSteps);
            $selectedStep = $possibleSteps[0];
            foreach ($steps as $step) {
                unset($remainingBefores[$step][$selectedStep]);
            }
            $ans1 .= $selectedStep;
            if (strlen($ans1) == count($steps)) {
                break;
            }
        }
        // ---------- Part 2
        $ans2 = 0;
        $maxWorkers = count($input) == 7 ? self::MAX_WORKERS_EXAMPLE : self::MAX_WORKERS_PART2;
        $durationBase = count($input) == 7 ? self::DURATION_BASE_EXAMPLE : self::DURATION_BASE_PART2;
        $remainingBefores = $befores;
        $workersIdleAt = array_fill(0, $maxWorkers, 0);
        $stepsCompleteAt = [];
        foreach ($steps as $step) {
            $stepsCompleteAt[$step] = -1;
        }
        $times = [0];
        $completed = '';
        while (true) {
            $times = array_unique($times);
            if (count($times) == 0) {
                break;
            }
            sort($times);
            $t = array_shift($times);
            $finishingSteps = array_keys(array_filter(
                $stepsCompleteAt,
                static fn ($x) => $x == $t,
            ));
            foreach ($finishingSteps as $stepComplete) {
                foreach ($steps as $step) {
                    unset($remainingBefores[$step][$stepComplete]);
                }
                $completed .= $stepComplete;
            }
            if (strlen($completed) == count($steps)) {
                break;
            }
            $availableWorkers = array_keys(array_filter(
                $workersIdleAt,
                static fn ($x) => $x <= $t,
            ));
            if (count($availableWorkers) == 0) {
                continue;
            }
            $possibleSteps = array_values(array_filter(
                $steps,
                static fn ($step) => count($remainingBefores[$step] ?? []) == 0
                    && !str_contains($completed, $step)
                    && $stepsCompleteAt[$step] == -1,
            ));
            sort($possibleSteps);
            for ($i = 0; $i < min(count($availableWorkers), count($possibleSteps)); ++$i) {
                $selectedStep = $possibleSteps[$i];
                $duration = $durationBase + ord($selectedStep) - ord('A') + 1;
                $workersIdleAt[$availableWorkers[$i]] = $t + $duration;
                $stepsCompleteAt[$selectedStep] = $t + $duration;
                $times[] = $t + $duration;
                $ans2 = intval(max($ans2, $t + $duration));
            }
        }
        return [strval($ans1), strval($ans2)];
    }
}
