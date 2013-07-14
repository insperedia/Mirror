<?php
/**
 * Author: Serafim
 * Date: 14.07.13 1:50
 * Package: Mirror SessionAdaptor.php 
 */
namespace Mirror\Cache;

/**
 * Class SessionAdaptor
 * @package Mirror\Cache
 */
class SessionAdaptor implements CacheInterface
{
    const SECTION = 'mirror.cache';
    const SECTION_TIME  = 'mtime';
    const SECTION_VALUE = 'value';


    /**
     * @todo: А надо ли оно ваще?
     */
    public function __construct()
    {
        session_start();
        if (!isset($_SESSION[self::SECTION])) {
            $_SESSION[self::SECTION] = [];
        }
    }

    /**
     * @param $data
     * @return mixed|void
     */
    public function has($data)
    {
        return
            $this->_hasData($data) &&
            $this->_checkTimestamp($data);
    }

    /**
     * @param $data
     * @return mixed|void
     */
    public function get($data)
    {
        return $this->_getValue($data);
    }

    /**
     * @param $data
     * @param $value
     * @return mixed|void
     */
    public function set($data, $value)
    {
        return $_SESSION[self::SECTION][$data]
            = $this->_serialize($value, time());
    }

    /**
     * @param $value
     * @param $timestamp
     * @return string
     */
    private function _serialize($value, $timestamp)
    {
        return json_encode([
                self::SECTION_TIME  => $timestamp,
                self::SECTION_VALUE => $value
            ]);
    }

    /**
     * @param $data
     * @return mixed
     */
    private function _unserialize($data)
    {
        return json_decode($data);
    }

    /**
     * @param $name
     * @return bool
     */
    private function _hasData($name)
    {
        return isset($_SESSION[self::SECTION][$name]);
    }

    /**
     * @param $name
     * @return mixed
     */
    private function _getTimestamp($name)
    {
        return $this->_unserialize($_SESSION[self::SECTION][$name])[self::SECTION_TIME];
    }

    /**
     * @param $name
     * @return mixed
     */
    private function _getValue($name)
    {
        return $this->_unserialize($_SESSION[self::SECTION][$name])[self::SECTION_VALUE];
    }

    /**
     * @param $path
     * @return bool
     */
    private function _checkTimestamp($path)
    {
        return $this->_getTimestamp($path) >= filemtime($path);
    }
}