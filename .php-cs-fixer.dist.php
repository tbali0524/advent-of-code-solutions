<?php

/**
 * php-cs-fixer configuration file.
 *
 * minimum version: ^3.66
 *
 * @see https://cs.symfony.com/doc/config.html
 */

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->name('*.php')
    ->ignoreVCSIgnored(true)
    ->exclude('.git/')
    ->exclude('.tools/')
    ->exclude('vendor/')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PHP84Migration' => true,
        '@PHP82Migration:risky' => true,    // this also needs: ->setRiskyAllowed(true)
        '@PhpCsFixer' => true,              // includes @Symfony, @PER-CS2.0, @PSR12, @PSR2, @PSR1
        '@PhpCsFixer:risky' => true,        // includes @Symfony:risky, @PER-CS2.0:risky, @PSR12:risky
        '@PHPUnit100Migration:risky'=> true,

        // override some @Symfony rules
        'blank_line_before_statement' => false,
        'concat_space' => ['spacing' => 'one'],
        'phpdoc_to_comment' => false,
        'yoda_style' => false,

        // override some @PhpCsFixer rules
        'single_line_empty_body' => false,

        // override some @Symfony:risky rules
        'is_null' => false,
        'logical_operators' => false,
        'modernize_types_casting' => false,
        'native_constant_invocation' => false,
        'native_function_invocation' => false,
        'no_trailing_whitespace_in_string' => false,
        'psr_autoloading' => false,
        'string_length_to_empty' => false,

        // override some @PhpCsFixer:risky rules
        'comment_to_phpdoc' => false,
        'strict_comparison' => false,
    ])
    ->setRiskyAllowed(true)
    ->setCacheFile(__DIR__ . '/.tools/.php-cs-fixer.cache')
    ->setIndent("    ")
    ->setLineEnding("\n")
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
    ->setFinder($finder)
;
