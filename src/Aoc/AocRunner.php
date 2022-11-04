<?php

/**
 * Advent of Code - class for the CLI runner.
 */

declare(strict_types=1);

namespace TBali\Aoc;

use TBali\Aoc\SolutionBase as Base;

final class AocRunner
{
    public const MIN_YEAR = 2015;
    public const MAX_YEAR = 2022;
    public const MIN_DAYS = 1;
    public const MAX_DAYS = 25;

    // array<int year, array<int day>>
    public const TO_SKIP = [
        2020 => [20],
    ];

    /**
     * id => [commandline, extension].
     *
     * @var array<string, array{string, string}>
     */
    public const LANGUAGES = [
        'lua' => ['lua', 'lua'],
        'perl' => ['perl', 'pl'],
        'php' => ['php', 'php'],
        'python' => ['python', 'py'],
        'ruby' => ['ruby', 'rb'],
    ];

    private const ERROR_TAG = Base::ANSI_RED . '[ERROR]' . Base::ANSI_RESET . ' ';

    public int $year = -1;
    public int $day = -1;
    public bool $runAsScripts = false;
    public string $language = '';
    public bool $isOk = true;

    /**
     * @param string[] $args the PHP $argv of the invoking script (args are from index 1)
     */
    public function __construct(array $args)
    {
        echo 'AoC v1.0 - batch solution runner for Advent of Code, (c) 2022 by TBali' . PHP_EOL . PHP_EOL;
        $this->processArgs($args);
        $this->isOk = true;
    }

    /** runs all matching solutions based on $this->year, $this->day (-1 meaning 'all') */
    public function run(): void
    {
        $startTime = hrtime(true);
        if (($this->year >= 0) and ($this->day >= 0)) {
            if ($this->runAsScripts) {
                $this->runSingleAsScript($this->year, $this->day);
            } else {
                $this->runSingleAsClass($this->year, $this->day);
            }
            echo PHP_EOL;
            return;
        }
        $countTotal = 0;
        $countFails = 0;
        $countSkipped = 0;
        for ($year = self::MIN_YEAR; $year <= self::MAX_YEAR; ++$year) {
            if (($this->year >= 0) and ($year != $this->year)) {
                continue;
            }
            echo '======= ' . $year . ' ===========================' . PHP_EOL;
            for ($day = 1; $day <= self::MAX_DAYS; ++$day) {
                $srcFileName = $this->getSourceName($year, $day);
                if (!file_exists($srcFileName)) {
                    continue;
                }
                ++$countTotal;
                if (in_array($day, self::TO_SKIP[$year] ?? [])) {
                    echo '=== AoC ' . $year . ' Day ' . $day . PHP_EOL;
                    echo Base::WARN_TAG . 'Skipped.' . PHP_EOL;
                    ++$countSkipped;
                    continue;
                }
                if ($this->runAsScripts) {
                    $result = $this->runSingleAsScript($year, $day);
                } else {
                    $result = $this->runSingleAsClass($year, $day);
                }
                if (!$result) {
                    ++$countFails;
                }
            }
        }
        $spentTime = number_format((hrtime(true) - $startTime) / 1_000_000_000, 4, '.', '');
        $totalMsg = $countTotal . ' solution' . ($countTotal > 1 ? 's' : '');
        $messages = [];
        if ($countFails > 0) {
            $messages[] = $countFails . ' failed';
        }
        if ($countSkipped > 0) {
            $messages[] = $countSkipped . ' skipped';
        }
        if (($countFails > 0) or ($countSkipped > 0)) {
            $failSkipMsg = ' (' . implode(', ', $messages) . ')';
        } else {
            $failSkipMsg = '';
        }
        echo '======= Total: ' . $totalMsg . $failSkipMsg . ' [time: ' . $spentTime . ' sec]' . PHP_EOL;
        if ($countTotal > 0) {
            if ($countFails == 0) {
                echo PHP_EOL . Base::ANSI_GREEN . '[ OK ] All tests passed. ' . Base::ANSI_RESET . PHP_EOL;
            } else {
                echo PHP_EOL . Base::ANSI_RED . '[ERROR] There were some unsuccessful tests. ' . Base::ANSI_RESET
                    . PHP_EOL;
            }
        } else {
            echo PHP_EOL . Base::WARN_TAG . 'There was nothing to run. ' . PHP_EOL;
        }
        echo PHP_EOL;
    }

    /** runs a single solution class */
    public function runSingleAsClass(int $year, int $day): bool
    {
        if ($this->runAsScripts) {
            return false;
        }
        $srcFileName = $this->getSourceName($year, $day);
        if (!$this->checkFileExists($srcFileName)) {
            return false;
        }
        $className = $this->getClassName($year, $day);
        $fullClassName = 'TBali\\Aoc' . $year . '\\' . $className;
        /** @var Solution */
        $solution = new $fullClassName();
        $success = $solution->run();
        if (!$success) {
            $this->isOk = false;
        }
        return $success;
    }

    /** runs a single solution script */
    public function runSingleAsScript(int $year, int $day): bool
    {
        if (!$this->runAsScripts) {
            return false;
        }
        $srcFileName = $this->getSourceName($year, $day);
        if (!$this->checkFileExists($srcFileName)) {
            return false;
        }
        $runCommand = (self::LANGUAGES[$this->language][0] ?? 'php') . ' ' . $srcFileName;
        if (PHP_OS_FAMILY == 'Windows') {
            $runCommand = str_replace('/', '\\', $runCommand);
        }
        $execResultCode = 0;
        $execResult = system($runCommand, $execResultCode);
        if (($execResult === false) or ($execResultCode != 0)) {
            $this->isOk = false;
            echo self::ERROR_TAG . 'Execution failed for ' . $srcFileName . PHP_EOL;
            return false;
        }
        return true;
    }

    /** @param string[] $args (the PHP $argv of the script) */
    private function processArgs(array $args): void
    {
        $errorMsg = self::ERROR_TAG . 'Invalid command line arguments' . PHP_EOL . PHP_EOL
            . 'Usage:  php src/aoc.php [language] [year] [day]' . PHP_EOL
            . PHP_EOL
            . '+----------------------------+-----------------------------------------------------+' . PHP_EOL
            . '| Argument                   | Effect                                              |' . PHP_EOL
            . '+----------------------------+-----------------------------------------------------+' . PHP_EOL
            . '| LANGUAGE given             | invoke interpreter with standalone solution scripts |' . PHP_EOL
            . '| LANGUAGE not given         | invoke class-based PHP solutions                    |' . PHP_EOL
            . '| none of YEAR and DAY given | run all solutions                                   |' . PHP_EOL
            . '| only YEAR given            | run all solutions for that season only              |' . PHP_EOL
            . '| both YEAR and DAY given    | run a specific solution                             |' . PHP_EOL
            . '+----------------------------+-----------------------------------------------------+' . PHP_EOL
            . PHP_EOL
            . 'Possible values for [language]: ' . implode(', ', array_keys(self::LANGUAGES)) . PHP_EOL
            . PHP_EOL;
        if (count($args) > 4) {
            echo $errorMsg;
            exit(1);
        }
        $this->year = -1;
        $this->day = -1;
        $this->runAsScripts = false;
        $this->language = '';
        if (count($args) == 1) {
            return;
        }
        $idxYear = 1;
        if (isset(self::LANGUAGES[strtolower($args[1])])) {
            $this->runAsScripts = true;
            $this->language = strtolower($args[1]);
            $idxYear = 2;
        }
        if (count($args) == $idxYear + 2) {
            $this->day = intval($args[$idxYear + 1]);
            if (($this->day < self::MIN_DAYS) or ($this->day > self::MAX_DAYS)) {
                echo $errorMsg;
                exit(1);
            }
        }
        if (count($args) >= $idxYear + 1) {
            $this->year = intval(strtolower($args[$idxYear]));
            if (($this->year < self::MIN_YEAR) or ($this->year > self::MAX_YEAR)) {
                echo $errorMsg;
                exit(1);
            }
        }
    }

    private function getClassName(int $year, int $day): string
    {
        return 'Aoc' . $year . 'Day' . str_pad(strval($day), 2, '0', STR_PAD_LEFT);
    }

    private function getSourceName(int $year, int $day): string
    {
        return 'src/Aoc' . $year . '/' . $this->getClassName($year, $day) . '.'
            . ($this->runAsScripts ? self::LANGUAGES[$this->language][1] ?? '' : 'php');
    }

    private function checkFileExists(string $srcFileName): bool
    {
        if (!file_exists($srcFileName)) {
            echo self::ERROR_TAG . 'Cannot find solution source file: ' . $srcFileName . PHP_EOL;
            $this->isOk = false;
            return false;
        }
        return true;
    }
}
