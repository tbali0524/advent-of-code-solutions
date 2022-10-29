<?php

/**
 * Advent of Code - common abstract class for every solution class.
 */

declare(strict_types=1);

namespace TBali\Aoc;

abstract class SolutionBase implements Solution
{
    final public function run(): bool
    {
        $startTime = hrtime(true);
        $isOk = true;
        $ansiGreen = "\e[1;37;42m";
        $ansiRed = "\e[1;37;41m";
        $ansiReset = "\e[0m";
        $errorTag = $ansiRed . '[FAIL]' . $ansiReset . ' ';
        $okTag = $ansiGreen . '[ OK ]' . $ansiReset . ' ';
        $baseFileName = 'input/' . static::YEAR . '/aoc' . str_pad(strval(static::YEAR % 100), 2, '0', STR_PAD_LEFT)
            . '_' . str_pad(strval(static::DAY), 2, '0', STR_PAD_LEFT);
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
                if (static::EXAMPLE_STRING_INPUTS[$example] == '') {
                    continue;
                }
                $input = [static::EXAMPLE_STRING_INPUTS[$example]];
            }
            ++$countExamples;
            $answers = $this->solve($input);
            for ($part = 0; $part < 2; ++$part) {
                if ($answers[$part] != strval(static::EXAMPLE_SOLUTIONS[$example][$part])) {
                    $isOk = false;
                    $exampleMsg .= $errorTag . 'Puzzle example #' . ($example + 1) . ' part ' . ($part + 1)
                        . ' result: ' . $answers[$part] . ' not matching expected solution: '
                        . static::EXAMPLE_SOLUTIONS[$example][$part] . PHP_EOL;
                }
            }
        }
        if ($isOk and ($countExamples > 0)) {
            $exampleMsg = $okTag . 'Puzzle example' . ($countExamples > 1 ? 's' : '') . ' passed.'
                . PHP_EOL;
        }
        $fileName = $baseFileName . '.txt';
        $input = static::readInput($fileName);
        $answers = $this->solve($input);
        $spentTime = number_format((hrtime(true) - $startTime) / 1000_000_000, 4, '.', '');
        $maxMemory = strval(ceil(memory_get_peak_usage(true) / 1000_000));
        echo '=== AoC ' . static::YEAR . ' Day ' . static::DAY . ' [time: ' . $spentTime . ' sec, memory: '
            . $maxMemory . ' MB] : ' . static::TITLE . PHP_EOL . $exampleMsg;
        for ($part = 0; $part < 2; ++$part) {
            if ($answers[$part] != strval(static::SOLUTIONS[$part])) {
                $isOk = false;
                echo $errorTag . $answers[$part] . ' not matching expected solution: '
                    . static::SOLUTIONS[$part] . PHP_EOL;
                continue;
            }
            echo $okTag . $answers[$part] . PHP_EOL;
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
