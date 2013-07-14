<?php
/**
 * Author: Serafim
 * Date: 12.07.13 11:42
 * Package: Mirror Token.php 
 */
namespace Mirror\Core;

use Mirror\Tokens;

/**
 * Class Token
 * @package Mirror\Core
 */
class Token
    extends     TokenIterator
    implements  TokenInterface
{
    use \Mirror\Helpers\TypeCasting;

    /**
     * Create new token array by content
     * @param string $tok
     * @return array
     */
    private function _undefinedToken($tok)
    {
        self::isString($tok); # type casting
        $id = Tokens::getIdByValue($tok);
        return [
            $id,
            $tok,
            self::getTokenById($this->_id - 1)->getLine() // @todo это может не работать =)
        ];
    }

    /**
     * Token id
     * @var int
     */
    private $_id        = 0;

    /**
     * Token define id
     * @var int
     */
    private $_tokConst  = 0;

    /**
     * Token define name
     * @var string
     */
    private $_tokConstName  = Tokens::T_UNDEFINED;

    /**
     * Token declare line
     * @var int
     */
    private $_line      = 0;

    /**
     * Token content
     * @var string
     */
    private $_content   = '';

    /**
     * Appended data
     * @var array
     */
    private $_append    = [];

    /**
     * Prepended data
     * @var array
     */
    private $_prepend   = [];

    /**
     * Token was removed
     * @var bool
     */
    private $_deleted   = false;

    /**
     * Create token by token array or token string
     * @param array|string $token
     */
    public function __construct($token)
    {
        $this->_id = self::setToken($this);
        if (!is_array($token)) {
            $token = $this->_undefinedToken($token);
        }

        list($id, $content, $line) = $token;
        $id = ($tid = Tokens::getIdByValue(trim($content)))
            ? $tid
            : $id;
        $this->_tokConst    = $id;
        $this->_content     = $content;
        $this->_line        = $line;
        $this->_tokConstName= Tokens::getName($id);
    }

    /**
     * Return line of token
     * @return int
     */
    public function getLine()
    {
        return $this->_line;
    }

    /**
     * Return id of token
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Return define name of token
     * @return string
     */
    public function getName()
    {
        return $this->_tokConstName;
    }

    /**
     * Return define result
     * @return int
     */
    public function getDefine()
    {
        return constant($this->getName());
    }

    /**
     * Return content of token
     * @return string
     */
    public function getContent()
    {
        return $this->_content;
    }

    /**
     * Append content
     * @param string $content
     * @return int
     */
    public function append($content)
    {
        self::isString($content); # type casting
        $this->_append[] = $content;
        return count($this->_append);
    }

    /**
     * Return append data
     * @return array
     */
    public function getAppend()
    {
        return $this->_append;
    }

    /**
     * Prepend content
     * @param string $content
     * @return int
     */
    public function prepend($content)
    {
        self::isString($content); # type casting
        $this->_prepend[] = $content;
        return count($this->_prepend);
    }

    /**
     * Return prepend data
     * @return array
     */
    public function getPrepend()
    {
        return $this->_prepend;
    }

    /**
     * Delete token
     * @param bool $del
     * @return bool
     */
    public function delete($del = true)
    {
        self::isBoolean($del); # type casting
        return $this->_deleted = $del;
    }

    /**
     * Is deleted?
     * @return bool
     */
    public function deleted()
    {
        return $this->_deleted;
    }

    /**
     * Return next token
     * @param int $step
     * @return Token
     */
    public function next($step = 1)
    {
        return self::getTokenById($this->_id + $step);
    }


    /**
     * Return previous token
     * @param int $step
     * @return Token
     */
    public function prev($step = 1)
    {
        return self::getTokenById($this->_id - $step);
    }

    /**
     * @param $token
     * @return mixed
     */
    public function findNext($token, $searchMethod = 'getDefine')
    {
        $token = is_array($token) ? $token : [$token];

        $for = $this->_id + 1;
        for ($i = $for; $i<self::tokensLength(); $i++) {
            if (in_array(self::getTokenById($i)->$searchMethod(), $token)) {
                return self::getTokenById($i);
            }
        }
    }

    /**
     * @param $token
     * @return mixed
     */
    public function findPrev($token, $searchMethod = 'getDefine')
    {
        $token = is_array($token) ? $token : [$token];

        $for = $this->_id - 1;
        for ($i = $for; $i > 0; $i--) {
            if (in_array(self::getTokenById($i)->$searchMethod(), $token)) {
                return self::getTokenById($i);
            }
        }
    }

    /**
     * Remove all data
     */
    public function fullDelete()
    {
        $this->_deleted = true;
        $this->_append  = [];
        $this->_prepend = [];
    }

    /**
     * Replace content (sprintf string)
     * @param string $content
     * @return string
     */
    public function replace($content)
    {
        self::isString($content); # type casting
        $this->_content = sprintf($content, $this->_content);
        return $this->_content;
    }

    /**
     * Replace content
     * @param $from
     * @param $to
     * @return mixed
     */
    public function replaceContent($from, $to)
    {
        $this->_content = str_replace($from, $to, $this->_content);
        return $this->_content;
    }

    /**
     * Merge tokens
     * @param Token $token
     * @return $this
     */
    public function merge(Token $token)
    {
        $token->delete();
        array_unshift($this->_append, $token->getContent());
        return $this;
    }
}