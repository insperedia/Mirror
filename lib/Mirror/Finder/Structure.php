<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Serafim
 * Date: 16.07.13 12:57
 * Package: Mirror Structure.php 
 */
namespace Mirror\Finder;

use Mirror\Tokenizer\Token;

/**
 * Class Structure
 * @package Mirror\Finder
 */
class Structure
{
    const STRUCT_OPEN   = 'T_STRUCT_OPEN';
    const STRUCT_CLOSE  = 'T_STRUCT_CLOSE';

    private $_token;

    public function __construct(Token $token)
    {
        $this->_token = $token;
    }

    /**
     * Возвращает содержание последующей структуры
     * $ignoreLevels - исключает из массива токенов все внутренние структуры
     * @param bool $ignoreLevels
     * @return array
     */
    public function next($ignoreLevels = true)
    {
        $found = [];
        $token  = $this->_token;

        $level = 0;
        $finder = false;

        while ($token->getDefine() != T_END_OF_FILE) {
            if ($token->getDefine() == constant(self::STRUCT_OPEN)) {
                $level++;
                if ($finder && $ignoreLevels) {
                    $tok = $token;
                    $i = count($found);
                    while (isset($found[--$i]) && !in_array($found[$i]->getDefine(), [T_EXPR_END, T_STRUCT_OPEN])) {
                        unset($found[$i]);
                    }
                    /**
                     * Пересоздаём индекс
                     * Говнокод детектед
                     */
                    $f = [];
                    foreach ($found as $find) { $f[] = $find; }
                    $found = $f;
                }
                $finder = true;
            }
            if ($finder && $level <= 0) {
                return $found;
            } else if ($level <= 1 && $ignoreLevels) {
                $found[] = $token;
            }
            if ($token->getDefine() == constant(self::STRUCT_CLOSE)) { $level--; }
            $token = $token->next();
        }
        return $found;
    }
}