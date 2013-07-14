<?php
/**
 * Author: Serafim
 * Date: 10.07.13 21:24
 * Package: Mirror Tokens.php
 */
namespace Mirror;

/**
 * Class Tokens
 * @package Mirror
 */
class Tokens
{
    use \Mirror\Helpers\TypeCasting;
    const T_UNDEFINED = 'UNKNOWN';

    /**
     * Added tokens ID
     * @var int
     */
    private static $_tokenIterator  = 1000;

    /**
     * Declared tokens
     * @var array
     */
    private static $_declaredTokens = [];

    /**
     * ID => NAME defined tokens hash
     * @var array
     */
    private static $_definedTokens  = [];

    /**
     * Add token:
     * $name    - T_DEFINE
     * $value   - String value
     * $id      - Token define ID
     *
     * @param string $name
     * @param string $value
     * @param null $id
     */
    public static function append($name, $value, $id = null)
    {
        self::isString($name);  # type casting
        self::isString($value); # type casting

        $id = ($id === null) ? self::$_tokenIterator++ : $id;
        self::$_declaredTokens[$value]  = $id;
        defined($name) or define($name, $id);
        self::$_definedTokens[$id]      = $name;
    }

    /**
     * Get token name by ID
     * @param int $id
     * @return string
     */
    public static function getName($id)
    {
        self::isInteger($id); # type casting

        if (($name = token_name($id)) === self::T_UNDEFINED) {
            return isset(self::$_definedTokens[$id])
                ? self::$_definedTokens[$id]
                : self::T_UNDEFINED;
        }
        return $name;
    }


    /**
     * Get Token ID by token define
     * @param string $name
     * @return int
     */
    public static function getId($name)
    {
        self::isString($name); # type casting
        return defined($name)
            ? constant($name)
            : 0;
    }

    /**
     * Return declared id by value
     * @param string $value
     * @return int
     */
    public static function getIdByValue($value)
    {
        self::isString($value); # type casting
        return isset(self::$_declaredTokens[$value])
            ? self::$_declaredTokens[$value]
            : 0;
    }
}