<?php

/**
 * Advent of Code - CLI solution runner - for standalone solution scripts.
 */

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use TBali\Aoc\Runner;

$runner = new Runner($argv, true);
$runner->run();
exit($runner->isOk ? 0 : 1);
