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

/**
 * Class Init
 * @package Mirror\Glass\Std
 */
class Init
{
    const INIT_NAME = '__init';

    /**
     * @param $tokens
     */
    public function __construct($tokens)
    {
        $scopes = (new Finder(
            'function', self::INIT_NAME, $tokens, Finder::TYPE_CONTENT
        ))->getScopes();

        $functions  = (new Group($scopes))->find(T_FUNCTION);

        foreach ($functions as $func) {
            if (
                $func->prev(2)->getDefine() != T_PRIVATE &&
                $func->prev(4)->getDefine() != T_PRIVATE &&
                $func->prev(2)->getDefine() != T_PROTECTED &&
                $func->prev(4)->getDefine() != T_PROTECTED &&
                (
                    $func->prev(2)->getDefine() == T_STATIC ||
                    $func->prev(4)->getDefine() == T_STATIC
                )
            ) {
                $class    = $func->findPrev(T_CLASS);
                $name = $class->next(2)->getContent();
                $class
                    ->findNext(T_END_OF_FILE)
                    ->prepend("\n" . $name . '::' . self::INIT_NAME . '();');
            }
        }
    }
}