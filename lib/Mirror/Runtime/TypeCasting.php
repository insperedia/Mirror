<?php
/**
 * Author: Serafim
 * Date: 14.07.13 2:15
 * Package: Mirror TypeCasting.php 
 */
namespace Mirror\Runtime;

/**
 * Class TypeCasting
 * @package Mirror\Runtime
 */
class TypeCasting
{
    /**
     * Casts
     * @var array
     */
    private static $_typeCasts = [
        'integer', 'int', // alias
        'string',
        'array',
        'bool',
        'float', 'double', // alias
        'scalar',
        'resource',
        'callable',
        'object'
    ];

    /**
     * Validate
     * @param $arg
     * @param array $types
     * @throws \TypeException
     */
    public static function validate($arg, array $types)
    {
        foreach ($types as $type) {
            if (!self::_check($arg, $type)) {
                return self::_typeException($arg, $type);
            }
        }
    }

    /**
     * Call exception for type casting
     * @param $arg
     * @param $type
     * @throws \TypeException
     */
    private static function _typeException($arg, $type)
    {
        $arg = str_replace(["\n\r", "\r\n", "\n ", "\n"], '', print_r($arg, 1));
        while (strstr($arg, '  ')) { $arg = str_replace('  ', ' ', $arg); }
        if (strlen($arg) > 30) {
            $arg = substr($arg, 0, 30) . '...';
        }
        throw new \TypeException("Can not convert `${arg}` to `${type}`.");
    }

    /**
     * Validate type
     * @param $arg
     * @param $type
     * @return mixed
     */
    private static function _check($arg, $type)
    {
        $foo = 'is_' . $type;
        return $foo($arg);
    }

    /**
     * Can cast?
     * @param $type
     * @return bool
     */
    public static function canCast($type)
    {
        return in_array($type, self::$_typeCasts);
    }

    /**
     * Return casts array
     * @return array
     */
    public static function getTypeCasts()
    {
        return self::$_typeCasts;
    }
}