<?php
/**
 * Author: Serafim
 * Date: 10.07.13 21:21
 * Package: Mirror v5-5.php 
 */
namespace Mirror\Tokens;

$tokens = [
    'yield'     => [267, 'T_YIELD'],
    'finally'	=> [340, 'T_FINALLY']
];

foreach ($tokens as $val => $name) {
    list($id, $name) = $name;
    \Mirror\Tokens::append($name, $val, $id);
}