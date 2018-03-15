<?php

$header = <<<'EOF'
This file is part of bhittani/repository.

(c) Kamal Khan <shout@bhittani.com>

This source file is subject to the MIT license that
is bundled with this source code in the file LICENSE.
EOF;

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        '@Symfony' => true,
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
        'not_operator_with_successor_space' => true,
        'no_short_echo_tag' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'ordered_class_elements' => true,
        'ordered_imports' => ['sortAlgorithm' => 'length'],
        'phpdoc_add_missing_param_annotation' => true,
        'phpdoc_order' => true,
        'single_line_after_imports' => true,
    ])->setFinder(PhpCsFixer\Finder::create()->in(__DIR__ . '/src'))
;
