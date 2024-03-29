<?php
/**
 * Author: Serafim
 * Date: 13.07.13 17:24
 * Package: Mirror Scope.php 
 */
namespace Mirror\Finder;

/**
 * Class Scope
 * @package Mirror\Finder
 */
class Scope
{
    /**
     * Search types
     */
    const TYPE_DEFINE   = 1;
    const TYPE_CONTENT  = 2;

    /**
     * Tokens
     * @var array
     */
    private $_tokens = [];

    /**
     * Create Scope
     * @param $tokens
     */
    public function __construct($tokens)
    {
        $this->_tokens = $tokens;
    }


    /**
     * Search in scope
     * @param array|int|string $haystack
     * @param int $type
     * @return array
     */
    public function find($haystack, $type = self::TYPE_DEFINE)
    {
        $haystack = is_array($haystack) ? $haystack : [$haystack];
        $checkToken = function($token) use ($type) {
            return ($type == self::TYPE_DEFINE)
                ? $token->getDefine()
                : trim($token->getContent());
        };

        $results = [];
        foreach ($this->_tokens as $token) {
            if (in_array($checkToken($token), $haystack)) {
                $results[] = $token;
            }
        }
        return $results;
    }

    /**
     * Удалить всё содержимое токенов
     */
    public function delete()
    {
        foreach ($this->_tokens as $token) {
            $token->delete();
        }
    }
}