#!/usr/bin/php
<?php

$finder = PhpCsFixer\Finder::create()
    ->files()
    ->name('*.php')
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
;

$config = PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        '@DoctrineAnnotation' => true,
        '@PhpCsFixer' => true,
        '@PHP71Migration' => true,

        'blank_line_after_namespace' => true,
        'single_import_per_statement' => true,
        'single_line_after_imports' => true,
        'no_unused_imports' => true,

        'ordered_imports' => true,
        'global_namespace_import' => true,
        'ordered_class_elements' => [
            'order' => [
                'use_trait',
                'constant',
                'constant_public',
                'constant_protected',
                'constant_private',
                'property_public_static',
                'property_public',
                'property_protected_static',
                'property_protected',
                'property_private_static',
                'property_private',
                'construct',
                'destruct',
                'magic',
                'phpunit',
                'method_public_static',
                'method_public',
                'method_protected_static',
                'method_protected',
                'method_private_static',
                'method_private',
            ],
        ],

        'method_chaining_indentation' => false,

        'nullable_type_declaration_for_default_null_value' => [
            'use_nullable_type_declaration' => false,
        ],

        'final_static_access' => true,
        'self_static_accessor' => true,

        'ternary_to_null_coalescing' => true,
        'binary_operator_spaces' => [
            'default' => 'single_space',
            'operators' => [
                '=' => 'align_single_space_minimal',
                '+=' => 'align_single_space_minimal',
                '-=' => 'align_single_space_minimal',
                '/=' => 'align_single_space_minimal',
                '*=' => 'align_single_space_minimal',
                '%=' => 'align_single_space_minimal',
                '**=' => 'align_single_space_minimal',
                '=>' => 'align_single_space_minimal',
            ],
        ],
        'yoda_style' => [
            'equal' => false,
            'identical' => false,
            'less_and_greater' => null,
        ],
        'concat_space' => [
            'spacing' => 'one'
        ],
        'array_syntax' => [
            'syntax' => 'short'
        ],
        'braces' => true,
        'elseif' => true,
        'trim_array_spaces' => true,

        'function_declaration' => true,
        'no_spaces_after_function_name' => true,
        'no_spaces_inside_parenthesis' => true,

        'cast_spaces' => true,
        'encoding' => true,
        'full_opening_tag' => true,
        'linebreak_after_opening_tag' => true,
        'no_closing_tag' => true,
        'indentation_type' => true,
        'line_ending' => true,
        'single_blank_line_at_eof' => false,
        'no_trailing_whitespace' => true,
        'lowercase_keywords' => true,
        'no_whitespace_in_blank_line' => true,
        'no_short_echo_tag' => true,

        'doctrine_annotation_braces' => false,
        'doctrine_annotation_array_assignment' => [
            'operator' => '=',
        ],

        'align_multiline_comment' => [
            'comment_type' => 'all_multiline'
        ],

        'no_superfluous_phpdoc_tags' => false,
        'phpdoc_order' => true,
        'phpdoc_separation' => true,
        'phpdoc_var_without_name' => false,
        'phpdoc_var_annotation_correct_order' => true,
        'phpdoc_types_order' => [
            'sort_algorithm'  => 'none',
            'null_adjustment' => 'always_last',
        ],
    ])
    ->setUsingCache(true)
    ->setFinder($finder)
;

if (version_compare(PHP_VERSION, '7.1', '>=')) {
  $config->setRules(array_merge($config->getRules(), [
    'list_syntax' => [
        'syntax' => 'short',
    ],
  ]));
}


return $config;