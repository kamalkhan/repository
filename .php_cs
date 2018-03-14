<?php

$header = <<<'EOF'
This file is part of bhittani/repository.

(c) Kamal Khan <shout@bhittani.com>

For the full copyright and license information, please view
the LICENSE file that was distributed with this source code.
EOF;

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'combine_consecutive_unsets' => true,
        'header_comment' => ['header' => $header],
        'heredoc_to_nowdoc' => true,
        'no_extra_consecutive_blank_lines' => [
            'break',
            'continue',
            'extra',
            'return',
            'throw',
            'use',
            'parenthesis_brace_block',
            'square_brace_block',
            'curly_brace_block'
        ],
        'no_short_echo_tag' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'ordered_class_elements' => true,
        'ordered_imports' => false,
        'phpdoc_add_missing_param_annotation' => true,
        'phpdoc_order' => true,
        'semicolon_after_instruction' => true,
    ])->setFinder(PhpCsFixer\Finder::create()->in(__DIR__ . '/src'))
;
