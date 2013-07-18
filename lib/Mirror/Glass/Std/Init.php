<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Serafim
 * Date: 15.07.13 21:38
 * Package: Mirror Init.php 
 */
namespace Mirror\Glass\Std;

use Mirror\Finder;
use Mirror\Finder\Scope;
use Mirror\Finder\Group;

class Init
{
    const INIT_NAME = '__init';

    public function __construct($tokens)
    {
        $scopes = (new Finder(
            'function', self::INIT_NAME, $tokens, Finder::TYPE_CONTENT
        ))->getScopes();

        $functions  = (new Group($scopes))->find(T_FUNCTION);

        foreach ($functions as $func) {
            if (
                (
                    $func->prev(2)->getDefine() == T_PUBLIC ||
                    $func->prev(2)->getDefine() == T_STATIC
                ) &&
                (
                    $func->prev(4)->getDefine() == T_PUBLIC ||
                    $func->prev(4)->getDefine() == T_STATIC
                )
            ) {
                $classes    = (new Group($functions))->findPrev(T_CLASS);

                foreach ($classes as $class) {
                    $t = (new \Mirror\Finder\Structure($class))->next();
                    $t[count($t) - 1]
                        ->append(
                            "\n" . ($class->next(2)->getContent()) .
                            '::' . self::INIT_NAME . '();'
                        );
                }
            }
        }
    }
}