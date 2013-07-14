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
    const CAST_LINK = "\\Mirror\\Runtime\\TypeCasting::%s(%s);\n";

    private static $_casts = [
        'int'       => 'isInteger',
        'integer'   => 'isInteger',
        'str'       => 'isString',
        'string'    => 'isString',
        'object'    => 'isObject',
        'res'       => 'isResource',
        'resource'  => 'isResource',
        'array'     => 'isArray',
        'double'    => 'isDouble',
        'float'     => 'isDouble',
        'scalar'    => 'isScalar',
        'callable'  => 'isCallable',
        'func'      => 'isCallable',
        'bool'      => 'isBoolean',
        'boolean'   => 'isBoolean'
    ];

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
                $var->prev(1)->getDefine() == T_WHITESPACE &&
                isset(self::$_casts[$var->prev(2)->getContent()])
            ) {
                $var->prev(1)->delete(); // T_WHITESPACE
                $var->prev(2)->delete(); // TYPE CASTING

                $var->findNext(T_STRUCT_OPEN) // Search "{"
                    ->append(
                        sprintf(
                            self::CAST_LINK,
                            self::$_casts[$var->prev(2)->getContent()],
                            $var->getContent()
                        )
                    );
            }
        }
    }

    /**
     * Return all available type casts
     * @return array
     */
    public static function getTypeCasts()
    {
        return array_keys(self::$_casts);
    }
}