<?php
/**
 * Author: Serafim
 * Date: 10.07.13 21:24
 * Package: Mirror Tokenizer.php 
 */
namespace Mirror;

use Mirror\Tokenizer\Token;
use Mirror\Tokenizer\AbstractInitializer;

/**
 * Class Tokenizer
 * @package Mirror
 */
class Tokenizer extends AbstractInitializer
{
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
     * Путь к файлу текущего итератора
     * @var string
     */
    private $_file = '';

    /**
     * Новый токен итератор для файла $file
     * @param $data
     * @param $file
     */
    public function __construct($data, $file)
    {
        $this->_file= $file;
        $tokens     = token_get_all($data);
        $tokens[]   = [
            T_END_OF_FILE,
            '',
            -1
        ];
        foreach ($tokens as $tok) {
            $this->_tokens[] = new Token($tok, $this->_file);
        }

        foreach (\Mirror::getDefaultGlasses() as $glass) {
            $glass = 'Mirror\\Glass\\' . $glass;
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

    /**
     * Возвращает путь к исходнику набора токенов
     * @return string
     */
    public function getSourceFile()
    {
        return $this->_file;
    }
}
Tokenizer::__init();