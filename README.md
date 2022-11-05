# Advent of Code solutions in PHP by TBali

![php-version-81](https://shields.io/badge/php->=8.1-blue)

* [AoC website](https://adventofcode.com/)
* My AoC username: `tbali0524`

## Batch solution runner

Run solutions from the project base directory with:

```sh
php src/aoc.php [LANGUAGE] [YEAR] [DAY]
```

| Argument                       | Effect                                              |
|:-------------------------------|:----------------------------------------------------|
| `LANGUAGE` given               | invoke interpreter with standalone solution scripts |
| `LANGUAGE` not given           | invoke class-based PHP solutions                    |
| none of `YEAR` and `DAY` given | run all solutions                                   |
| only `YEAR` given              | run all solutions for that season only              |
| both `YEAR` and `DAY` given    | run a specific solution                             |

On Windows, the shortcut `.\aoc.bat [LANGUAGE] [YEAR] [DAY]` also works.

Possible values for `LANGUAGE`: _lua, perl, php, python, ruby_.

_Note: Before first run, use `composer install` to setup the class autoloader. There are __NO__ 3rd-party package depencdencies._

## Puzzle inputs

* directory pattern: `input/YYYY/`
* filename pattern: `aocYY_DD.txt`
* optional additional example inputs are in `aocYY_DDex1.txt` and `aocYY_DDex2.txt`

## Solutions source

* directory pattern:  `src/AocYYYY/`
* filename pattern: `AocYYYYDayDD.php` (or `.py`, `.rb`, etc. for standalone scripts in other languages)
* class-based PHP solutions:
    * for a new solution, use the template in `src/Aoc/Aoc2022Day00.php`
    * solution should implement class `AocYYYYDayDD`, extending `BaseSolution`
    * should implement `solve()` method and override constants in `Solution` interface
    * the `solve()` method must be callable repeatedly with different inputs
    * after successful submit, the puzzle answers shall be recorded in the `SOLUTIONS` class constant (for future test runs.)
