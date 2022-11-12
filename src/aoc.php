#!/usr/bin/env php
<?php

/**
 * Advent of Code - CLI solution runner.
 */

declare(strict_types=1);

namespace TBali;

require __DIR__ . '/../vendor/autoload.php';

use TBali\Aoc\AocRunner;

$runner = new AocRunner($argv);
$runner->run();
exit($runner->isOk ? 0 : 1);
