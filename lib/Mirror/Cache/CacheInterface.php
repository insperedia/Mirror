<?php
/**
 * Author: Serafim
 * Date: 14.07.13 1:25
 * Package: Mirror CacheInterface.php 
 */
namespace Mirror\Cache;

/**
 * Interface CacheInterface
 * @package Mirror\Cache
 */
interface CacheInterface
{
    /**
     * Cached?
     * @param $name
     * @return mixed
     */
    public function has($name);

    /**
     * Return cache data
     * @param $name
     * @return mixed
     */
    public function get($name);

    /**
     * Set new data
     * @param $name
     * @param $data
     * @return mixed
     */
    public function set($name, $data);
}