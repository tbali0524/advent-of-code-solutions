<?php

declare(strict_types=1);

namespace TBali\Aoc;

/**
 * Common abstract class that every AoC solution class should extend.
 *
 * @author Bálint Tóth
 */
abstract class SolutionBase implements Solution
{
    private const SLOW_THRESHOLD = 10.0;   // seconds
    private const MEMORY_THRESHOLD = 1024; // megabytes

    /**
     * The main runner engine.
     *
     * Calls readInput() (only if needed) and solve() for all examples, then for the puzzle itself, outputs results.
     *
     * @return bool Did all tests pass?
     *
     * @codeCoverageIgnore
     */
    final public function run(): bool
    {
        if (version_compare(PHP_VERSION, '8.2.0', '>=')) {
            gc_collect_cycles();
            memory_reset_peak_usage();
        }
        $startTime = hrtime(true);
        $isOk = true;
        $baseFileName = 'input/' . static::YEAR . '/Aoc' . static::YEAR . 'Day'
            . str_pad(strval(static::DAY), 2, '0', STR_PAD_LEFT);
        // run examples, if there is any
        $exampleMsg = '';
        $countExamples = 0;
        for ($example = 0; $example < count(static::EXAMPLE_SOLUTIONS); ++$example) {
            if ((static::EXAMPLE_STRING_INPUTS[$example] ?? '') === '') {
                $fileName = $baseFileName . 'ex' . strval($example + 1) . '.txt';
                if (!file_exists($fileName)) {
                    continue;
                }
                $input = static::readInput($fileName);
            } else {
                $input = [static::EXAMPLE_STRING_INPUTS[$example]];
            }
            ++$countExamples;
            $answers = $this->solve($input);
            if (
                (strval(static::EXAMPLE_SOLUTIONS[$example][0]) == '0')
                and (strval(static::EXAMPLE_SOLUTIONS[$example][1]) == '0')
            ) {
                $isOk = false;
                $exampleMsg .= Tags::WARN_TAG . 'Puzzle example #' . ($example + 1)
                    . ' is missing expected result.' . PHP_EOL;
                continue;
            }
            for ($part = 0; $part < 2; ++$part) {
                if (strval(static::EXAMPLE_SOLUTIONS[$example][$part]) == '0') {
                    continue;
                }
                if ($answers[$part] != strval(static::EXAMPLE_SOLUTIONS[$example][$part])) {
                    $isOk = false;
                    $exampleMsg .= Tags::ERROR_TAG . 'Puzzle example #' . ($example + 1) . ' part ' . ($part + 1)
                        . ' result: ' . $answers[$part] . ' not matching expected solution: '
                        . static::EXAMPLE_SOLUTIONS[$example][$part] . PHP_EOL;
                }
            }
        }
        if ($isOk and ($countExamples > 0)) {
            $exampleMsg = Tags::OK_TAG . 'Puzzle example' . ($countExamples < 2 ? '' : 's (' . $countExamples . ')')
                . ' passed.' . PHP_EOL;
        }
        // run for large inputs, if there is any
        $largeMsg = '';
        $countLarge = 0;
        for ($large = 0; $large < count(static::LARGE_SOLUTIONS); ++$large) {
            $fileName = $baseFileName . 'large' . strval($large + 1) . '.txt';
            if (!file_exists($fileName)) {
                continue;
            }
            $input = static::readInput($fileName);
            ++$countLarge;
            $answers = $this->solve($input);
            for ($part = 0; $part < 2; ++$part) {
                if (strval(static::LARGE_SOLUTIONS[$large][$part]) == '0') {
                    $largeMsg .= Tags::WARN_TAG . 'Large input #' . ($large + 1) . ' part ' . ($part + 1)
                        . ' result: ' . $answers[$part] . PHP_EOL;
                    continue;
                }
                if ($answers[$part] != strval(static::LARGE_SOLUTIONS[$large][$part])) {
                    $isOk = false;
                    $largeMsg .= Tags::ERROR_TAG . 'Result for large input #' . ($large + 1) . ' part ' . ($part + 1)
                        . ' result: ' . $answers[$part] . ' not matching expected solution: '
                        . static::LARGE_SOLUTIONS[$large][$part] . PHP_EOL;
                }
            }
            if (!$isOk) {
                break;
            }
            if (
                (strval(static::LARGE_SOLUTIONS[$large][0]) != '0')
                and (strval(static::LARGE_SOLUTIONS[$large][1]) != '0')
            ) {
                $largeMsg .= Tags::OK_TAG . 'Puzzle for large input #' . ($large + 1) . ' passed.' . PHP_EOL;
            }
        }
        // run the solution
        $fileName = $baseFileName . '.txt';
        if (static::STRING_INPUT == '') {
            $fileName = $baseFileName . '.txt';
            if (!file_exists($fileName)) {
                echo '=== AoC ' . static::YEAR . ' Day ' . str_pad(strval(static::DAY), 2, '0', STR_PAD_LEFT)
                    . ' : ' . static::TITLE . PHP_EOL . $exampleMsg;
                echo Tags::ERROR_TAG . 'Cannot find input file: ' . $fileName . PHP_EOL;
                return false;
            }
            $input = static::readInput($fileName);
        } else {
            $input = [static::STRING_INPUT];
        }
        $answers = $this->solve($input);
        // stats and report
        $spentTime = (hrtime(true) - $startTime) / 1_000_000_000;
        $spentTimeMsg = number_format($spentTime, 3, '.', '');
        if ($spentTime >= self::SLOW_THRESHOLD) {
            $spentTimeMsg = Tags::ANSI_YELLOW . $spentTimeMsg . Tags::ANSI_RESET;
        }
        $maxMemoryMsg = '';
        $padTitle = 0;
        if (version_compare(PHP_VERSION, '8.2.0', '>=')) {
            $maxMemory = ceil(memory_get_peak_usage() / 1024 / 1024);
            $maxMemoryMsg = strval($maxMemory);
            $padTitle = 4 - strlen($maxMemoryMsg);
            if ($maxMemory >= self::MEMORY_THRESHOLD) {
                $maxMemoryMsg = Tags::ANSI_YELLOW . $maxMemoryMsg . Tags::ANSI_RESET;
            }
            $maxMemoryMsg = '; memory: ' . $maxMemoryMsg . ' Mbytes';
        }
        echo '=== AoC ' . static::YEAR . ' Day ' . str_pad(strval(static::DAY), 2, '0', STR_PAD_LEFT)
            . ' [time: ' . $spentTimeMsg . ' sec' . $maxMemoryMsg . ']' . str_repeat(' ', $padTitle) . ' '
            . static::TITLE . PHP_EOL . $exampleMsg . $largeMsg;
        for ($part = 0; $part < 2; ++$part) {
            if ((static::DAY == 25) and ($part == 1)) {
                continue;
            }
            if (strval(static::SOLUTIONS[$part]) == '0') {
                echo Tags::WARN_TAG . $answers[$part] . ' - Puzzle is missing expected result.' . PHP_EOL;
                continue;
            }
            if ($answers[$part] != strval(static::SOLUTIONS[$part])) {
                $isOk = false;
                echo Tags::ERROR_TAG . $answers[$part] . ' not matching expected solution: '
                    . static::SOLUTIONS[$part] . PHP_EOL;
                continue;
            }
            echo Tags::OK_TAG . $answers[$part] . PHP_EOL;
        }
        return $isOk;
    }

    /**
     * Read a file into an array of lines (without LF).
     *
     * @return array<int, string>
     *
     * @phpstan-return non-empty-list<string>
     *
     * @throws \Exception
     */
    final public static function readInput(string $fileName): array
    {
        if (!file_exists($fileName)) {
            throw new \Exception('Cannot open input file: ' . $fileName);
        }
        $handle = fopen($fileName, 'r');
        if ($handle === false) {
            // @codeCoverageIgnoreStart
            throw new \Exception('Cannot open input file: ' . $fileName);
            // @codeCoverageIgnoreEnd
        }
        $input = [];
        while (true) {
            $line = fgets($handle);
            if ($line === false) {
                break;
            }
            $input[] = rtrim($line);
        }
        fclose($handle);
        if (count($input) == 0) {
            throw new \Exception('Input file contains no data.' . $fileName);
        }
        return $input;
    }

    /**
     * The filename of the input file with relative path but without the extension.
     */
    final public function inputBaseFileName(): string
    {
        return 'input/' . static::YEAR . '/Aoc' . static::YEAR . 'Day'
            . str_pad(strval(static::DAY), 2, '0', STR_PAD_LEFT);
    }
}
