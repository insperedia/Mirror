<?php
/**
 * Author: Serafim
 * Date: 13.07.13 17:43
 * Package: Mirror Group.php 
 */
namespace Mirror\Finder;

/**
 * Class Group
 * @package Mirror\Finder
 */
class Group
{
    /**
     * Scopes
     * @var array
     */
    private $_scopes = [];

    /**
     * Linked data
     * @var bool
     */
    private $_link = false;

    /**
     * @param $scopes
     */
    public function __construct($scopes)
    {
        $this->_scopes = $scopes;
    }


    /**
     * Return all data by link
     * @return $this
     */
    public function byLink()
    {
        $this->_link = true;
        return $this;
    }

    /**
     * Return all data by value
     * @return $this
     */
    public function byVal()
    {
        $this->_link = false;
        return $this;
    }

    /**
     * Call method
     * @param $foo
     * @param $args
     * @return array|mixed
     */
    public function __call($foo, $args)
    {
        $results = [];
        foreach ($this->_scopes as $scope) {
            $result = call_user_func_array([$scope, $foo], $args);
            if (is_array($result)) {
                $results = array_merge($results, $result);
            } else {
                $results[] = $result;
            }
        }

        return $this->_link
            ? $this
            : $results;
    }
}