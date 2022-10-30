<?php

/**
 * Advent of Code - common abstract class for every solution class.
 */

declare(strict_types=1);

namespace TBali\Aoc;

abstract class SolutionBase implements Solution
{
    public const ANSI_RED = "\e[1;37;41m";
    public const ANSI_GREEN = "\e[1;37;42m";
    public const ANSI_YELLOW = "\e[1;37;43m";
    public const ANSI_RESET = "\e[0m";
    public const ERROR_TAG = self::ANSI_RED . '[FAIL]' . self::ANSI_RESET . ' ';
    public const WARN_TAG = self::ANSI_YELLOW . '[WARN]' . self::ANSI_RESET . ' ';
    public const OK_TAG = self::ANSI_GREEN . '[ OK ]' . self::ANSI_RESET . ' ';

    /** returns true if all tests passed */
    final public function run(): bool
    {
        $startTime = hrtime(true);
        // memory_reset_peak_usage(); // requires PHP v8.2
        $isOk = true;
        $baseFileName = 'input/' . static::YEAR . '/aoc'
            . str_pad(strval(static::YEAR % 100), 2, '0', STR_PAD_LEFT)
            . '_' . str_pad(strval(static::DAY), 2, '0', STR_PAD_LEFT);
        // run examples, if there is any
        $exampleMsg = '';
        $countExamples = 0;
        for ($example = 0; $example < 2; ++$example) {
            if (static::EXAMPLE_STRING_INPUTS[$example] == '') {
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
            for ($part = 0; $part < 2; ++$part) {
                if (strval(static::EXAMPLE_SOLUTIONS[$example][$part]) == '0') {
                    if ($part > 0) {
                        continue;
                    }
                    $isOk = false;
                    $exampleMsg .= self::WARN_TAG . 'Puzzle example #' . ($example + 1)
                        . ' is missing expected result.' . PHP_EOL;
                    continue;
                }
                if ($answers[$part] != strval(static::EXAMPLE_SOLUTIONS[$example][$part])) {
                    $isOk = false;
                    $exampleMsg .= self::ERROR_TAG . 'Puzzle example #' . ($example + 1) . ' part ' . ($part + 1)
                        . ' result: ' . $answers[$part] . ' not matching expected solution: '
                        . static::EXAMPLE_SOLUTIONS[$example][$part] . PHP_EOL;
                }
            }
        }
        if ($isOk and ($countExamples > 0)) {
            $exampleMsg = self::OK_TAG . 'Puzzle example' . ($countExamples > 1 ? 's' : '') . ' passed.'
                . PHP_EOL;
        }
        // run the solution
        $fileName = $baseFileName . '.txt';
        if (static::STRING_INPUT == '') {
            $fileName = $baseFileName . '.txt';
            if (!file_exists($fileName)) {
                echo '=== AoC ' . static::YEAR . ' Day ' . static::DAY . ' : ' . static::TITLE . PHP_EOL . $exampleMsg;
                echo self::ERROR_TAG . 'Cannot find input file: ' . $fileName . PHP_EOL;
                return false;
            }
            $input = static::readInput($fileName);
        } else {
            $input = [static::STRING_INPUT];
        }
        $answers = $this->solve($input);
        // stats and report
        $spentTime = number_format((hrtime(true) - $startTime) / 1000_000_000, 4, '.', '');
        $maxMemory = strval(ceil(memory_get_peak_usage(true) / 1000_000));
        echo '=== AoC ' . static::YEAR . ' Day ' . static::DAY . ' [time: ' . $spentTime . ' sec, memory: '
            . $maxMemory . ' MB] : ' . static::TITLE . PHP_EOL . $exampleMsg;
        for ($part = 0; $part < 2; ++$part) {
            if (strval(static::SOLUTIONS[$part]) == '0') {
                echo self::WARN_TAG . $answers[$part] . ' - Puzzle is missing expected result.' . PHP_EOL;
                continue;
            }
            if ($answers[$part] != strval(static::SOLUTIONS[$part])) {
                $isOk = false;
                echo self::ERROR_TAG . $answers[$part] . ' not matching expected solution: '
                    . static::SOLUTIONS[$part] . PHP_EOL;
                continue;
            }
            echo self::OK_TAG . $answers[$part] . PHP_EOL;
        }
        return $isOk;
    }

    // --------------------------------------------------------------------
    /** @return string[] */
    final public static function readInput(string $fileName): array
    {
        $handle = fopen($fileName, 'r');
        if ($handle === false) {
            throw new \Exception('Cannot load input file: ' . $fileName);
        }
        $input = [];
        while (true) {
            $line = fgets($handle);
            if ($line === false) {
                break;
            }
            $input[] = trim($line);
        }
        fclose($handle);
        return $input;
    }
}
