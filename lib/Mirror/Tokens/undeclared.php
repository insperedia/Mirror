<?php
/**
 * Author: Serafim
 * Date: 10.07.13 21:24
 * Package: Mirror undeclared.php 
 */
namespace Mirror\Tokens;

$tokens = [
    '{'     => 'T_STRUCT_OPEN',
    '}'     => 'T_STRUCT_CLOSE',
    '='     => 'T_EQUAL',
    ';'     => 'T_EXPR_END',
    '('     => 'T_SCOPE_OPEN',
    ')'     => 'T_SCOPE_CLOSE',
    ','     => 'T_ARG_DMTR',
    '.'     => 'T_CONCAT',
    '!'     => 'T_EXPR_REVERSE',
    '['     => 'T_ARRAY_OPEN',
    ']'     => 'T_ARRAY_CLOSE',
    '?'     => 'T_EXP_TERNARY',
    ':'     => 'T_EXP_TERNARY_FALSE',
    '+'     => 'T_EXP_PLUS',
    '-'     => 'T_EXP_MINUS',
    '/'     => 'T_EXP_DIVIDE',
    '*'     => 'T_EXP_MULTIPLY',
    '%'     => 'T_EXP_MODULE',
    "\0"    => 'T_END_OF_FILE'
];

foreach ($tokens as $val => $name) {
    \Mirror\Tokens::append($name, $val);
}