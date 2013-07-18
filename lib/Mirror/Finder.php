<?php
/**
 * Author: Serafim
 * Date: 13.07.13 16:50
 * Package: Mirror Finder.php
 */
namespace Mirror;

use Mirror\Finder\Scope;

/**
 * Class Scope
 * @package Mirror
 */
class Finder
{
    /**
     * Search types
     */
    const TYPE_DEFINES = 1;
    const TYPE_CONTENT = 2;

    /**
     * Scopes
     * @var array
     */
    private $_scopes = [];

    /**
     * Scope iterator
     * @var int
     */
    private $_scopeIterator = 0;

    /**
     * New Scope
     * @param $from
     * @param $to
     * @param array $tokens
     * @param int $type
     */
    public function __construct($from, $to, $tokens, $type = self::TYPE_DEFINES)
    {
        $from   = is_array($from)   ? $from : [$from];
        $to     = is_array($to)     ? $to   : [$to];
        $this->_search($from, $to, $tokens, $type);
    }

    /**
     * Finder
     * @param $from
     * @param $to
     * @param $tokens
     * @param $type
     */
    private function _search($from, $to, $tokens, $type)
    {
        $getToken = function($token) use ($type) {
            return ($type == self::TYPE_DEFINES)
                ? $token->getDefine()
                : trim($token->getContent());
        };

        $search = false;
        foreach ($tokens as $token) {
            if (in_array($getToken($token), $from)) {
                $search = true;
                $this->_scopes[$this->_scopeIterator] = [];
            }

            if ($search) {
                $this->_scopes[$this->_scopeIterator][] = $token;
            }

            if (in_array($getToken($token), $to)) {
                $search = 0;
                $this->_scopeIterator++;
            }
        }
    }

    /**
     * Return scopes
     * @return array
     */
    public function getScopes()
    {
        $scopes = [];
        foreach ($this->_scopes as $scope) {
            $scopes[] = new Scope($scope);
        }
        return $scopes;
    }
}