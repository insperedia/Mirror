<?php
/**
 * Author: Serafim
 * Date: 13.07.13 14:13
 * Package: Mirror Includes.php 
 */
namespace Mirror\Glass\Std;

use Mirror\Filter;
use Mirror\Finder;
use Mirror\Finder\Group;

/**
 * Class Includes
 * @package Mirror\Glass\Std
 */
class Includes
{
    /**
     * @param $tokens
     */
    public function __construct($tokens)
    {
        (new Group(
            (new Group(
                (new Finder(
                    [T_INCLUDE, T_INCLUDE_ONCE, T_REQUIRE, T_REQUIRE_ONCE],
                    T_EXPR_END,
                    $tokens
                ))->getScopes()
            ))->find(T_CONSTANT_ENCAPSED_STRING)
        ))
            ->byLink()
            ->replaceContent(['"', "'"], '')
            ->replace('"' . Filter::get('%s') . '"');
    }
}