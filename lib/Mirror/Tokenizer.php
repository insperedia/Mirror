<?php
/**
 * Author: Serafim
 * Date: 10.07.13 21:24
 * Package: Mirror Tokenizer.php 
 */
namespace Mirror;


use Mirror\Core\Token;
use Mirror\Tokenizer\AbstractInitializer;

/**
 * Class Tokenizer
 * @package Mirror
 */
class Tokenizer extends AbstractInitializer
{
    use \Mirror\Helpers\TypeCasting;

    /**
     * Initialize
     */
    public static function __init()
    {
        self::tokensInit();
    }

    /**
     * Tokens array
     * @var array
     */
    private $_tokens = [];

    /**
     * Source code
     * @var string
     */
    private $_data = '';

    /**
     * New file tokenizer
     * @param $data
     */
    public function __construct($data)
    {
        self::isString($data); # type casting
        $tokens     = token_get_all($data);
        $tokens[]   = [
            T_END_OF_FILE,
            '',
            -1
        ];
        foreach ($tokens as $tok) {
            $this->_tokens[] = new Token($tok);
        }

        foreach (\Mirror::getDefaultGlasses() as $glass) {
            new $glass($this->_tokens);
        }

        $this->_data = $this->_reviveData();
    }

    /**
     * Revive data from tokens
     * @return string
     */
    private function _reviveData()
    {
        $data = '';
        foreach ($this->_tokens as $token) {
            foreach ($token->getPrepend() as $prepend) 	{ $data .= $prepend; }
            if (!$token->deleted()) { $data .= $token->getContent(); }
            foreach ($token->getAppend() as $append) 	{ $data .= $append; }
        }
        return $data;
    }

    /**
     * Return data
     * @return string
     */
    public function getData()
    {
        return $this->_data;
    }
}
Tokenizer::__init();