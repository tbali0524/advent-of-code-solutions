<?php

declare(strict_types=1);

namespace TBali\Aoc;

/**
 * Ansi color and tag constants to be used for console output.
 */
abstract class Tags
{
    /** @var string */
    final public const ANSI_RED = "\e[1;37;41m";
    /** @var string */
    final public const ANSI_YELLOW = "\e[1;37;43m";
    /** @var string */
    final public const ANSI_GREEN = "\e[1;37;42m";
    /** @var string */
    final public const ANSI_INK_LIGHT_CYAN = "\e[96m";
    /** @var string */
    final public const ANSI_RESET = "\e[0m";
    /** @var string */
    final public const ERROR_TAG = self::ANSI_RED . '[FAIL]' . self::ANSI_RESET . ' ';
    /** @var string */
    final public const WARN_TAG = self::ANSI_YELLOW . '[WARN]' . self::ANSI_RESET . ' ';
    /** @var string */
    final public const OK_TAG = self::ANSI_GREEN . '[ OK ]' . self::ANSI_RESET . ' ';
}
