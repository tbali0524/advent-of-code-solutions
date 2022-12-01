# Advent of Code solutions in PHP by TBali

![php-version-81](https://shields.io/badge/php->=8.1-blue)

* [AoC website](https://adventofcode.com/)
* My AoC username: `tbali0524`
* [Puzzle list](puzzles.md) with topics and completion status.

## Installation

The solutions are using only the standard php library, they have NO 3rd-party package dependencies.
However, [Composer](https://getcomposer.org/) is used for its class autoloader:

```sh
composer install
```

Note: Some solutions require more memory than what a default PHP installation provides, so it is recommended to set `memory_limit = -1` in `php.ini`.

## Batch solution runner

Run solutions from the project base directory with:

```sh
php src/aoc.php [LANGUAGE] [YEAR] [DAY]
```

| Argument                       | Effect                                              |
|:-------------------------------|:----------------------------------------------------|
| `LANGUAGE` given               | invoke interpreter with standalone solution scripts |
| `all` given as the `LANGUAGE`  | invoke standalone solution scripts in all languages |
| `LANGUAGE` not given           | invoke class-based PHP solutions                    |
| none of `YEAR` and `DAY` given | run all solutions                                   |
| only `YEAR` given              | run all solutions for that season only              |
| both `YEAR` and `DAY` given    | run a specific solution                             |

On Windows, the shortcut `.\aoc.bat [LANGUAGE] [YEAR] [DAY]` also works.

Possible values for `LANGUAGE`:
_all, dart, f#, go, groovy, java, javascript, lua, perl, php, python, ruby, scala_.

## Puzzle input

* Directory pattern: `input/YYYY/`
* Filename pattern: `aocYY_DD.txt`
* Optional additional example input can be in `aocYY_DDex1.txt` and `aocYY_DDex2.txt`.
* Alternatively, a single string input can be given as the `STRING_INPUT` constant in the solution class.

## Class-based PHP solutions

* Directory pattern: `src/AocYYYY/`
* Filename pattern: `AocYYYYDayDD.php`, with the day `id` padded with zero to 2 digits.
* For a new solution, use the template in `src/Aoc/Aoc2022Day00.php`.
* Solution should implement class `AocYYYYDayDD`, extending `BaseSolution`.
* It should implement the `solve()` method and override the constants in the [Solution](src/Aoc/Solution.php) interface.
* The `solve()` method must be callable repeatedly with different inputs.
* After successful submit, the puzzle answers shall be recorded in the `SOLUTIONS` class constant (for future regression tests).

## Standalone script-based solutions

* Directory pattern: `src/other/AocYYYY/`
* Filename pattern: `AocYYYYDayDD.ext`, with the day `id` padded with zero to 2 digits.
    * (For `PHP` only: the pattern is `AocYYYYDayDDscr.php` to avoid having the same source filename as the class-based solution.)
* The script shall read the input file (if needed), print the problem ID and the solution.

## Custom Composer scripts

The following helper commands are defined in [composer.json](composer.json):

|Command      |Description |
|:------------|:-----------|
|start        |Run all solutions|
|cs           |Check coding style compliance to `PSR12` with [phpcs](https://github.com/squizlabs/PHP_CodeSniffer)|
|cs-fixer     |Check coding style compliance to `PSR12` plus extra rules with [php-cs-fixer](https://cs.symfony.com/) (no fix applied)|
|cs-fixer-do  |Apply coding style fixes with _php-cs-fixer_|
|doc          |Create documentation with [phpDocumentor](https://www.phpdoc.org/)|
|loc          |Get code summary report with [phploc](https://github.com/sebastianbergmann/phploc)|
|metrics      |Generate code metrics report with [phpmetrics](https://phpmetrics.github.io/website/)|
|stan         |Run static analysis with [phpstan](https://phpstan.org/)|
|qa           |Run code quality checks: _phpcs, php-cs-fixer, phpstan, phpmetrics, phpDocumentor_|
|open-doc     |Open generated documentation in browser _(fixed file path)_|
|open-metrics |Open generated code metrics report in browser _(fixed file path)_|
|clean        |Delete generated cache and report files in `.tools` directory _(Windows only)_|

Note: The above tools are NOT listed in `composer.json` as dev dependencies. Instead, the commands must be available in the `PATH`.
