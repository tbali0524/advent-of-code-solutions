<?php

/**
 * Advent of Code - class for the CLI runner.
 */

declare(strict_types=1);

namespace TBali\Aoc;

use TBali\Aoc\SolutionBase as Base;

final class Runner
{
    public int $year;
    public int $day;
    public bool $isOk;
    public bool $runAsScripts;

    public const MIN_YEAR = 2015;
    public const MAX_YEAR = 2022;
    public const MIN_DAYS = 1;
    public const MAX_DAYS = 25;

    public const SCRIPT_RUN_COMMAND = 'python';
    public const SCRIPT_EXTENSION = '.py';

    public const TO_SKIP = [
        2015 => [20, 24],
    ];

    private const ERROR_TAG = Base::ANSI_RED . '[ERROR]' . Base::ANSI_RESET . ' ';

    /** @param string[] $args (the PHP $argv of the script) */
    public function __construct(array $args, bool $runAsScripts = false)
    {
        echo 'AoC v1.0 - batch solution runner for Advent of Code, (c) 2022 by TBali' . PHP_EOL . PHP_EOL;
        [$this->year, $this->day] = $this->processArgs($args);
        $this->isOk = true;
        $this->runAsScripts = $runAsScripts;
    }

    /**
     * @param string[] $args (the PHP $argv of the script)
     *
     * @return array{int, int} year and day, -1 if not provided
     */
    private function processArgs(array $args): array
    {
        $errorMsg = self::ERROR_TAG . 'Invalid command line arguments' . PHP_EOL
            . 'Usage:  php src/aoc.php [year] [day]' . PHP_EOL;
        if (count($args) > 3) {
            echo $errorMsg;
            exit(1);
        }
        if (count($args) == 3) {
            $day = intval(strtolower($args[2]));
            if (($day < self::MIN_DAYS) or ($day > self::MAX_DAYS)) {
                echo $errorMsg;
                exit(1);
            }
        } else {
            $day = -1;
        }
        if (count($args) >= 2) {
            $year = intval(strtolower($args[1]));
            if (($year < self::MIN_YEAR) or ($year > self::MAX_YEAR)) {
                echo $errorMsg;
                exit(1);
            }
        } else {
            $year = -1;
        }
        return [$year, $day];
    }

    private function getClassName(int $year, int $day): string
    {
        return 'Aoc' . $year . 'Day' . str_pad(strval($day), 2, '0', STR_PAD_LEFT);
    }

    private function getSourceName(int $year, int $day): string
    {
        return 'src/Aoc' . $year . '/' . $this->getClassName($year, $day)
            . ($this->runAsScripts ? self::SCRIPT_EXTENSION : '.php');
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

    /** runs a single solution class */
    public function runSingleAsClass(int $year, int $day): bool
    {
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
        $srcFileName = $this->getSourceName($year, $day);
        if (!$this->checkFileExists($srcFileName)) {
            return false;
        }
        $runCommand = self::SCRIPT_RUN_COMMAND . ' ' . $srcFileName;
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

    /** runs all matching solutions based in $this->year, $this->day (-1 meaning 'all') */
    public function run(): void
    {
        $startTime = hrtime(true);
        if (($this->year >= 0) and ($this->day >= 0)) {
            if ($this->runAsScripts) {
                $this->runSingleAsScript($this->year, $this->day);
            } else {
                $this->runSingleAsClass($this->year, $this->day);
            }
            return;
        }
        $countRuns = 0;
        for ($year = self::MIN_YEAR; $year <= self::MAX_YEAR; ++$year) {
            if (($this->year >= 0) and ($year != $this->year)) {
                continue;
            }
            echo '======= ' . $year . ' ===========================' . PHP_EOL;
            for ($day = 1; $day <= self::MAX_DAYS; ++$day) {
                if (in_array($day, self::TO_SKIP[$year] ?? [])) {
                    continue;
                }
                $srcFileName = $this->getSourceName($year, $day);
                if (!file_exists($srcFileName)) {
                    continue;
                }
                if ($this->runAsScripts) {
                    $result = $this->runSingleAsScript($year, $day);
                } else {
                    $result = $this->runSingleAsClass($year, $day);
                }
                if ($result) {
                    ++$countRuns;
                }
            }
        }
        $spentTime = number_format((hrtime(true) - $startTime) / 1000_000_000, 4, '.', '');
        if ($countRuns > 1) {
            echo '======= Total: ' . $countRuns . ' solutions [time: ' . $spentTime . ' sec]' . PHP_EOL;
        }
        if ($this->isOk) {
            echo PHP_EOL . Base::ANSI_GREEN . '[ OK ] All tests passed. ' . Base::ANSI_RESET . PHP_EOL . PHP_EOL;
        } else {
            echo PHP_EOL . Base::ANSI_RED . '[ERROR] There were some unsuccessful tests. ' . Base::ANSI_RESET
                . PHP_EOL . PHP_EOL;
        }
    }
}
