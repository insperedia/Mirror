<?php
/**
 * Author: Serafim
 * Date: 11.07.13 18:40
 * Package: Mirror AbstractInitializer.php 
 */
namespace Mirror\Tokenizer;

/**
 * Class AbstractInitializer
 * @package Mirror\Tokenizer
 */
abstract class AbstractInitializer
{
    /**
     * @var array
     */
    private static $_tokens = [
        'undeclared'
    ];

    /**
     * @throws \PathException
     */
    protected static function tokensInit()
    {
        if (version_compare(phpversion(), '5.5') == -1) { self::$_tokens[] = 'v5-5'; }

        foreach (self::$_tokens as $tokenScope) {
            $path = __DIR__ . __DS__ . '..' . __DS__ .
                'Tokens' . __DS__ . $tokenScope . '.php';
            if (file_exists($path)) {
                require $path;
            } else {
                throw new \PathException("Token scope `${path}` not exists.");
            }
        }
    }
}