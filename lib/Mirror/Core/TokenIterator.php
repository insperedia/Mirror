<?php
/**
 * Author: Serafim
 * Date: 12.07.13 11:24
 * Package: Mirror TokenIterator.php 
 */
namespace Mirror\Core;

/**
 * Class TokenIterator
 * @package Mirror\Core
 */
abstract class TokenIterator
{
    use \Mirror\Helpers\TypeCasting;

    /**
     * Token iterator
     * @var int
     */
    private static $_iterator   = 0;

    /**
     * Tokens array
     * @var array
     */
    private static $_tokens     = [];

    /**
     * Append token
     * @param TokenInterface $token
     * @return int
     */
    protected static function setToken(TokenInterface $token)
    {
        self::$_tokens[self::$_iterator] = $token;
        return self::$_iterator++;
    }

    /**
     * Return Tokens count
     * @return int
     */
    protected static function tokensLength()
    {
        return count(self::$_tokens);
    }

    /**
     * Returned token by id
     * @param $id
     * @return mixed
     * @throws \OverflowException
     */
    protected static function getTokenById($id)
    {
        self::isInteger($id); # type casting
        if (isset(self::$_tokens[$id])) {
            return self::$_tokens[$id];
        }
        throw new \OverflowException("Can not find token with id = ${id}");
    }
}