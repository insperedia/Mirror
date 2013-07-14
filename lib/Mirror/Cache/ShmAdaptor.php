<?php
/**
 * Author: Serafim
 * Date: 14.07.13 1:44
 * Package: Mirror ShmAdaptor.php 
 */
namespace Mirror\Cache;

/**
 * Class ShmAdaptor: Shared Memory Adaptor
 * @package Mirror\Cache
 */
class ShmAdaptor implements CacheInterface
{
    const SEGMENT = 0xff3;

    /**
     * @todo: А надо ли?
     */
    public function __construct()
    {
        throw new \Exception('Пока не фурычит. Влом писать :3');
    }

    /**
     * @param $data
     * @return mixed|void
     */
    public function has($data)
    {
        return false;
    }

    /**
     * @param $data
     * @return mixed|void
     */
    public function get($data)
    {
        return false;
    }

    /**
     * @param $data
     * @param $value
     * @return mixed|void
     */
    public function set($data, $value)
    {
        return false;
    }
}