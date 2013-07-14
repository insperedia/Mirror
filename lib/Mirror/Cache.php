<?php
/**
 * Author: Serafim
 * Date: 13.07.13 20:40
 * Package: Mirror Cache.php 
 */
namespace Mirror;

use Mirror\Cache\CacheInterface;

/**
 * Class Cache
 * @package Mirror\Core
 */
class Cache implements CacheInterface
{
    /**
     * Disable cache define
     */
    const NO_CACHE  = 'MIRROR_NO_CACHE';

    /**
     * Adaptor instance
     * @var object
     */
    private $_adaptor = null;

    /**
     * New Cache
     * @param CacheInterface $adaptor
     */
    public function __construct(CacheInterface $adaptor)
    {
        $this->_adaptor = $adaptor;
    }

    /**
     * Return cache data
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        return $this->_adaptor->get($name);
    }

    /**
     * Set new cache
     * @param $name
     * @param $value
     * @return mixed
     */
    public function set($name, $value)
    {
        return $this->_adaptor->set($name, $value);
    }

    /**
     * Need update?
     * @param $name
     * @return mixed
     */
    public function has($name)
    {
        if (defined(self::NO_CACHE)) { return false; }
        return $this->_adaptor->has($name);
    }
}