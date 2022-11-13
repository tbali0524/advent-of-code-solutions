#!/usr/bin/env php
<?php

/**
 * Advent of Code - sample script to run a class-based solution without AocRunner.
 *
 * Instead of this, use aoc.php
 */

declare(strict_types=1);

namespace TBali;

require __DIR__ . '/../vendor/autoload.php';

echo '=== AoC 2017 Day 1 : Inverse Captcha' . PHP_EOL;
$solver = new \TBali\Aoc2017\Aoc2017Day01();
$input = $solver->readInput('input/2017/aoc17_01.txt');
[$ans1, $ans2] = $solver->solve($input);
echo $ans1 . PHP_EOL . $ans2 . PHP_EOL;
