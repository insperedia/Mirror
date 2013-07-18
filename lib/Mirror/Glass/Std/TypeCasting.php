<?php
/**
 * Author: Serafim
 * Date: 13.07.13 22:51
 * Package: Mirror TypeCasting.php 
 */
namespace Mirror\Glass\Std;

use Mirror\Finder;
use Mirror\Finder\Scope;
use Mirror\Finder\Group;

class TypeCasting
{
    const CAST_LINK = "\\Mirror\\Runtime\\TypeCasting::validate(%s, [%s]);\n";

    /**
     * @param $tokens
     */
    public function __construct($tokens)
    {
        $vars = (new Group(
            (new Finder(
                T_FUNCTION,
                T_STRUCT_OPEN,
                $tokens)
            )->getScopes()))
        ->find(T_VARIABLE);

        foreach ($vars as $var) {
            if (
                \Mirror\Runtime\TypeCasting::canCast($var->prev(1)->getContent()) ||
                (
                    $var->prev(1)->getDefine() == T_WHITESPACE &&
                    \Mirror\Runtime\TypeCasting::canCast($var->prev(2)->getContent())
                )
            ) {
                $var->prev(1)->delete(); // T_WHITESPACE
                $var->prev(2)->delete(); // TYPE CASTING
                /**
                 * @todo Добавить возможность кастовать сразу несколько значений
                 */
                $casts = ["'" . $var->prev(2)->getContent() . "'"];
                $var->findNext(T_STRUCT_OPEN) // Search "{"
                    ->append(
                        sprintf(
                            self::CAST_LINK,
                            $var->getContent(),
                            implode(', ', $casts)
                        )
                    );
            }
        }
    }
}