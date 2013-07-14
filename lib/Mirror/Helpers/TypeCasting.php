<?php
/**
 * Author: Serafim
 * Date: 09.07.13 15:31
 * Package: Mirror TypeCasting.php 
 */
namespace Mirror\Helpers;

use \Mirror\Exceptions\TypeException;

/**
 * Trait TypeCasting
 * @package Mirror\Helper
 */
trait TypeCasting
{
    /**
     * Parse Integer
     * @param $val
     */
    public static function isInt($val) { self::isInteger($val); }
    public static function isInteger($val)
    {
        if (!is_integer($val)) {
            $val = print_r($val, 1);
            throw new TypeException("Value `${val}` is not integer");
        }
    }

    /**
     * Parse String
     * @param $val
     */
    public static function isStr($val) { self::isString($val); }
    public static function isString($val)
    {
        if (!is_string($val)) {
            $val = print_r($val, 1);
            throw new TypeException("Value `${val}` is not string");
        }
    }

    /**
     * Parse Object
     * @param $val
     */
    public static function isObj($val) { self::isObject($val); }
    public static function isObject($val)
    {
        if (!is_object($val)) {
            $val = print_r($val, 1);
            throw new TypeException("Value `${val}` is not object");
        }
    }

    /**
     * Parse Scalar
     * @param $val
     */
    public static function isSclr($val) { self::isScalar($val); }
    public static function isScalar($val)
    {
        if (!is_scalar($val)) {
            $val = print_r($val, 1);
            throw new TypeException("Value `${val}` is not scalar");
        }
    }

    /**
     * Parse Callable
     * @param $val
     */
    public static function isFunction($val) { self::isCallable($val); }
    public static function isFn($val) { self::isCallable($val); }
    public static function isCb($val) { self::isCallable($val); }
    public static function isCallable($val)
    {
        if (!is_callable($val)) {
            $val = print_r($val, 1);
            throw new TypeException("Value `${val}` is not callable (lambda)");
        }
    }

    /**
     * Parse Resource
     * @param $val
     */
    public static function isRes($val) { self::isResource($val); }
    public static function isResource($val)
    {
        if (!is_resource($val)) {
            $val = print_r($val, 1);
            throw new TypeException("Value `${val}` is not resource");
        }
    }

    /**
     * Parse Float\Double
     * @param $val
     */
    public static function isDbl($val)   { self::isDouble($val); }
    public static function isFloat($val) { self::isDouble($val); }
    public static function isDouble($val)
    {
        if (!is_double($val)) {
            $val = print_r($val, 1);
            throw new TypeException("Value `${val}` is not double");
        }
    }

    /**
     * Parse Array
     * @param $val
     */
    public static function isArr($val) { self::isArray($val); }
    public static function isArray($val)
    {
        if (!is_array($val)) {
            $val = print_r($val, 1);
            throw new TypeException("Value `${val}` is not array");
        }
    }

    /**
     * Parse Boolean
     * @param $val
     */
    public static function isBool($val) { self::isBoolean($val); }
    public static function isBoolean($val)
    {
        if (!is_bool($val)) {
            $val = print_r($val, 1);
            throw new TypeException("Value `${val}` is not boolean");
        }
    }
}